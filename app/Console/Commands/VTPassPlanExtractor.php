<?php

namespace App\Console\Commands;

use App\Enums\CableProvider;
use App\Enums\DurationType;
use App\Enums\NetworkProvider;
use App\Models\VtPassPlan;
use App\Services\AnthropicAI\Anthropic;
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
        $aiVariations = collect($variations)->map(fn($variation) => [
            'variation_code' => $variation['variation_code'],
            'name' => $variation['name']
        ]);

        $aiResponse = app(Anthropic::class)->createMessage([
            ["role" => "user", "content" => $this->createPrompt($variations)]
        ]);
        $extractedPlans = json_decode($aiResponse['content'][0]['text'], true);

        $count = 0;
        foreach ($variations as $variation) {
            $planName = null;
            $isActive = true;
            $variationName = $variation['name'];
            $currentPlan = $extractedPlans[$variation['variation_code']];
            try {
                list($planName, $duration, $duration_type, $addition) = explode("|", $currentPlan);
            } catch (\Exception $ex) {
                dd($currentPlan);
            }

            $size = detectSize($variation['name']);
            $size_unit = detectSizeUnit($variation['name']);

            if ($this->isDataPlan($service) && (!$duration || !$duration_type)) {
                continue;
            }

            if ($this->isDataPlan($service) && (!$size || !$size_unit)) {
                $isActive = false;
            }

            logger()->info("{$variation['name']} <------> $currentPlan");

            VtPassPlan::updateOrCreate(
                ['code' => $variation['variation_code']],
                [
                    'service' => $service,
                    'code' => $variation['variation_code'],
                    'amount' => $variation['variation_amount'],
                    'name' => $variationName,
                    'label' => $planName,
                    'duration_type' => $duration_type,
                    'duration' => $duration,
                    'size' => $size,
                    'size_unit' => $size_unit,
                    'extras' => $addition,
                    'is_active' => $isActive,
                ]
            );

            $count++;
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
            Extract subscription plans from the following JSON data. Each plan should be formatted as a key-value pair:
            
            {
              "code": "name|duration|duration_type|bonus"
            }
            
            - `code`: The unique variation identifier from the original data.
            - `name`: The actual name of the plan, without unnecessary duration mentions.
              - Remove explicit duration (e.g., "1 Month", "1 Year", "7 Days") or cost (e.g., "19,000 Naira", "N2,400").
              - Retain relevant specifications like regions or categories.
            - `duration`: The duration of the plan as a number (e.g., 1 for 1 month, 1 for 1 week, etc.).
            - `duration_type`: The type of duration (e.g., "daily", "weekly", "monthly", "yearly", "one-off").
            - `bonus`: The bonus/extras added to the plans (e.g 9mobile 200MB (100MB + 100MB night) + 300secs - 1 day, 300secs in this case,
            27.5GB + 2GB Night N8000 Oneoff: 2GB Night, etc). In case like this 11GB (7GB+ 4GB Night)  where the plan is brokendown in a parenthesis
            don't take it as bonus.
            
            For all plans, if bonus does not exist, use empty space as the value of bonus because the segments of the string separted by | must be 4 
            If no explicit duration is found, assume `1|monthly`.
            For Glo Data, don't include the name Glo Data unless absolutely necessary.
            For Airtel Data, don't include the name Airtel Data Bundle unless absolutely necessary.
            
            
            Return the extracted data as a pure JSON object without any formatting or code blocks. Do not include triple backticks or any other surrounding text. The response should start with '{' and end with '}'.

            Here is the JSON data to process:
            $plan
        PROMPT;
    }
}
