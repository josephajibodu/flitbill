<?php

namespace App\Console\Commands;

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
    protected $signature = 'vtpass:plans {network}';

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
        $network = $this->argument('network');
        $vtPassClient = app(VTPassClient::class);
        $planCode = $vtPassClient->getPlanKeyByNetwork(NetworkProvider::from($network));

        $plans = [];
        if (is_array($planCode)) {
            foreach ($planCode as $code) {
                $response = $vtPassClient->getDataPlans($code);
                if (isset($response['content']['varations']) && is_array($response['content']['varations'])) {
                    $plans = array_merge($plans, $response['content']['varations']);
                }
            }
        } else {
            $response = $vtPassClient->getDataPlans($planCode);
            if (isset($response['content']['varations']) && is_array($response['content']['varations'])) {
                $plans = $response['content']['varations'];
            }
        }

        $this->parseAndStoreVariations($plans, $network);
        $this->info("Data plans for {$network} have been updated successfully.");
    }

    private function parseAndStoreVariations(array $variations, string $service)
    {
        // TODO: Use AI for this part since for more accuracy
        foreach ($variations as $variation) {
            $duration_type = detectDurationType($variation['name']);
            $duration = detectDuration($variation['name']);
            $size = detectSize($variation['name']);
            $size_unit = detectSizeUnit($variation['name']);
            $addition = detectAdditionalPart($variation['name']);

            logger()->info("{$variation['name']} <------> [{$duration_type?->value}] [{$duration}] - [{$size}] [{$size_unit?->value}] /Addition/ + {$addition}");

            if (!$duration || !$duration_type) {
                continue;
            }

            VtPassPlan::updateOrCreate(
                ['code' => $variation['variation_code']],
                [
                    'service' => $service,
                    'code' => $variation['variation_code'],
                    'amount' => $variation['variation_amount'],
                    'name' => $variation['name'],
                    'duration_type' => detectDurationType($variation['name']),
                    'duration' => detectDuration($variation['name']),
                    'size' => detectSize($variation['name']),
                    'size_unit' => $size_unit,
                    'extras' => $addition,
                    'is_active' => !$size_unit && !$size,
                ]
            );
        }
    }
}
