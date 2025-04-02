<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('transaction_id');
            $table->string('reference')->index();
            $table->string('amount');
            $table->string('tv_identifier')->nullable()->comment('smart card number');
            $table->string('plan');
            $table->string('provider')->comment('e.g. showmax');
            $table->string('service')->comment('e.g. vtpass');
            $table->string('status');
            $table->string('metadata');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cables');
    }
};
