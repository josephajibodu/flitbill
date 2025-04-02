<?php

use App\Enums\Electricity\MeterType;
use App\Enums\NetworkProvider;
use App\Services\AnthropicAI\Anthropic;
use App\Services\VTPass\VTPassClient;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('make:action {name}', function ($name) {
    $path = app_path("Actions/{$name}.php");

    if (file_exists($path)) {
        $this->error("Action '{$name}' already exists!");
        return;
    }

    $stub = "<?php\n\nnamespace App\\Actions;\n\nclass {$name}\n{\n    public function handle()\n    {\n        // Action logic here\n    }\n}";

    file_put_contents($path, $stub);
    $this->info("Action '{$name}' created successfully.");
})->purpose('Create a new action class in the App\\Actions namespace');

Artisan::command('anthropic:message', function () {
    $messages = [
        ["role" => "user", "content" => "Hello, Claude"]
    ];

    $response = app(Anthropic::class)->createMessage($messages);

    logger()->info("Claude response: ".json_encode($response));
})->purpose('Ask questions from Claude AI');

Artisan::command('anthropic:count', function () {
    $variations = json_encode([
        [
            "variation_code" => "nova",
            "name" => "Nova - 900 Naira - 1 Month",
            "variation_amount" => "900.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "basic",
            "name" => "Basic - 1,700 Naira - 1 Month",
            "variation_amount" => "1700.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "smart",
            "name" => "Smart - 2,200 Naira - 1 Month",
            "variation_amount" => "2200.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "classic",
            "name" => "Classic - 2,500 Naira - 1 Month",
            "variation_amount" => "2500.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "super",
            "name" => "Super - 4,200 Naira - 1 Month",
            "variation_amount" => "4200.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "nova-weekly",
            "name" => "Nova - 300 Naira - 1 Week",
            "variation_amount" => "300.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "basic-weekly",
            "name" => "Basic - 600 Naira - 1 Week",
            "variation_amount" => "600.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "smart-weekly",
            "name" => "Smart - 700 Naira - 1 Week",
            "variation_amount" => "700.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "classic-weekly",
            "name" => "Classic - 1200 Naira - 1 Week ",
            "variation_amount" => "1200.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "super-weekly",
            "name" => "Super - 1,500 Naira - 1 Week",
            "variation_amount" => "1500.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "nova-daily",
            "name" => "Nova - 90 Naira - 1 Day",
            "variation_amount" => "90.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "basic-daily",
            "name" => "Basic - 160 Naira - 1 Day",
            "variation_amount" => "160.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "smart-daily",
            "name" => "Smart - 200 Naira - 1 Day",
            "variation_amount" => "200.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "classic-daily",
            "name" => "Classic - 320 Naira - 1 Day ",
            "variation_amount" => "320.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "super-daily",
            "name" => "Super - 400 Naira - 1 Day",
            "variation_amount" => "400.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "ewallet",
            "name" => "ewallet Amount",
            "variation_amount" => "0.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "uni-1",
            "name" => "Chinese (Dish) - 19,000 Naira - 1 month",
            "variation_amount" => "19000.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "uni-2",
            "name" => "Nova (Antenna) - 1,900 Naira - 1 Month",
            "variation_amount" => "1900.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "special-weekly",
            "name" => "Classic (Dish) - 2300 Naira - 1 Week",
            "variation_amount" => "2300.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "special-monthly",
            "name" => "Classic (Dish) - 6800 Naira - 1 Month",
            "variation_amount" => "6800.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "nova-dish-weekly",
            "name" => "Nova (Dish) - 650 Naira - 1 Week",
            "variation_amount" => "650.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "super-antenna-weekly",
            "name" => "Super (Antenna) - 3,000 Naira - 1 Week",
            "variation_amount" => "3000.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "super-antenna-monthly",
            "name" => "Super (Antenna) - 8,800 Naira - 1 Month",
            "variation_amount" => "8800.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "global-monthly-dish",
            "name" => "Global (Dish) - 19000 Naira - 1 Month",
            "variation_amount" => "19000.00",
            "fixedPrice" => "Yes"
        ],
        [
            "variation_code" => "global-weekly-dish",
            "name" => "Global (Dish) - 6500 Naira - 1Week",
            "variation_amount" => "6500.00",
            "fixedPrice" => "Yes"
        ]
    ]);
    $message = <<<PROMPT
            Extract subscription plans from the following JSON data. Each plan should have the following fields:
            - name: The name of the plan (e.g., "Nova", "Basic", "Smart").
            - amount: The numerical price of the plan.
            - duration: The duration of the plan in numbers (e.g., 1 for 1 month, 1 for 1 week, etc.).
            - duration_type: The type of duration (e.g., "day", "week", "month").
            
            If the duration is not explicitly mentioned in the name, assume it is "1 month".
            
            Return the extracted data as pure JSON without any formatting or code blocks. Do not include triple backticks or any other surrounding text. The response should start with '{' and end with '}'.
            
            Here is the JSON data to process:
            $variations
        PROMPT;

    $messages = [
        ["role" => "user", "content" => $message]
    ];

    $response = app(Anthropic::class)->countToken($messages);

    $this->info("Token Count : ".json_encode($response));
})->purpose('Ask questions from Claude AI');

Artisan::command('app:test', function () {
    $client = app(VTPassClient::class);
    $data = app(VTPassClient::class)->purchaseAirtime(
        requestId: $client->generateRequestID(),
        providerId: 'mtn',
        amount: 5000,
        phoneNumber: '400032220000'
    );

    dd($data);
})->purpose('App test');