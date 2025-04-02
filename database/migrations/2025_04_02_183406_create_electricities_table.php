<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('electricities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('transaction_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('reference')->index();
            $table->string('amount');
            $table->string('meter_number');
            $table->string('provider')->comment('e.g. ibedc-electric');
            $table->string('service')->comment('e.g. vtpass');
            $table->string('meter_type');
            $table->string('token')->nullable();
            $table->string('status');
            $table->string('metadata');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('electricities');
    }
};
