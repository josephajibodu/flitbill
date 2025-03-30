<?php

use App\Enums\NetworkProvider;
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