<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('airtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('transaction_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('reference');
            $table->unsignedBigInteger('amount');
            $table->string('network')->comment('e.g. mtn');
            $table->string('phone_number');
            $table->string('service')->comment('e.g. vtpass');
            $table->string('status')->comment('delivery status');
            $table->longText('metadata');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('airtimes');
    }
};
