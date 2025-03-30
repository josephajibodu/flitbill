<?php

namespace App\Console\Commands;

use App\Enums\CableProvider;
use App\Enums\DurationType;
use App\Enums\NetworkProvider;
use App\Models\VtPassPlan;
use App\Services\VTPass\VTPassClient;
use Illuminate\Console\Command;

class VTPassPlanExtractor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vtpass:plans {provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the available plans for a service and update it in the DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $planProvider = $this->argument('provider');
        $vtPassClient = app(VTPassClient::class);

        $isDataPlan = $this->isDataPlan($planProvider);
        if ($isDataPlan) {
            $planCode = $vtPassClient->getPlanKeyByNetwork(NetworkProvider::from($planProvider));
        } else {
            $planCode = $vtPassClient->getCablePlanKeyByProvider(CableProvider::from($planProvider));
        }

        $plans = [];
        if (is_array($planCode)) {
            foreach ($planCode as $code) {
                $response = $vtPassClient->availablePlans($isDataPlan ? 'data' : 'cables', $code);

                if (isset($response['content']['varations']) && is_array($response['content']['varations'])) {
                    $plans = array_merge($plans, $response['content']['varations']);
                }
            }
        } else {
            $response = $vtPassClient->availablePlans($isDataPlan ? 'data' : 'cables', $planCode);

            if (isset($response['content']['varations']) && is_array($response['content']['varations'])) {
                $plans = $response['content']['varations'];
            }
        }

        $this->parseAndStoreVariations($plans, $planProvider);
        $this->info("Data plans for {$planProvider} have been updated successfully.");
    }

    private function parseAndStoreVariations(array $variations, string $service)
    {
        // TODO: Use AI for this part since for more accuracy
        foreach ($variations as $variation) {
            $variationName = $variation['name'];

            $planName = null;
            $duration_type = detectDurationType($variation['name']);
            $duration = detectDuration($variation['name']);
            $size = detectSize($variation['name']);
            $size_unit = detectSizeUnit($variation['name']);
            $addition = detectAdditionalPart($variation['name']);

            if ($this->isDataPlan($service) && (!$duration || !$duration_type)) {
                continue;
            }

            if ($this->isTVPlan($service)) {

                if (!$duration) {
                    $duration = 1;
                }

                if (!$duration_type) {
                    $duration_type = DurationType::Monthly;
                }
            }

            logger()->info("{$variation['name']} <------> [{$duration_type?->value}] [{$duration}] - [{$size}] [{$size_unit?->value}] ({$addition}) - Plan Name: $planName");


            VtPassPlan::updateOrCreate(
                ['code' => $variation['variation_code']],
                [
                    'service' => $service,
                    'code' => $variation['variation_code'],
                    'amount' => $variation['variation_amount'],
                    'name' => $planName ?? $variationName,
                    'duration_type' => $duration_type,
                    'duration' => $duration,
                    'size' => $size,
                    'size_unit' => $size_unit,
                    'extras' => $addition,
                    'is_active' => !$size_unit && !$size,
                ]
            );
        }
    }

    private function isDataPlan(string $network): bool
    {
        return in_array($network, NetworkProvider::values());
    }

    private function isTVPlan(string $network): bool
    {
        return in_array($network, CableProvider::values());
    }

    private function createPrompt(array $data): string
    {
        $plan = json_encode($data);

        return <<<PROMPT
            Extract subscription plans from the following JSON data. Each plan should have the following fields:
            - name: The name of the plan (e.g., "Nova", "Basic", "Smart").
            - amount: The numerical price of the plan.
            - duration: The duration of the plan in numbers (e.g., 1 for 1 month, 1 for 1 week, etc.).
            - duration_type: The type of duration (e.g., "day", "week", "month").
            
            If the duration is not explicitly mentioned in the name, assume it is "1 month".
            
            Return the extracted data in a structured JSON format like this:
            
            {
              "plans": [
                {
                  "name": "Nova",
                  "amount": 900.00,
                  "duration": 1,
                  "duration_type": "month"
                },
                {
                  "name": "Super Weekly",
                  "amount": 1500.00,
                  "duration": 1,
                  "duration_type": "week"
                }
              ]
            }
            
            Here is the JSON data to process:
            $plan
        PROMPT;
    }
}
