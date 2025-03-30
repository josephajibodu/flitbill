<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vt_pass_plans', function (Blueprint $table) {
            $table->id();

            $table->string('service');
            $table->string('code');
            $table->string('amount');
            $table->string('name');
            $table->string('label')->nullable();
            $table->string('duration_type');
            $table->string('duration');
            $table->string('size')->nullable();
            $table->string('size_unit')->nullable();
            $table->string("extras")->comment('additional bonus')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vt_pass_plans');
    }
};
