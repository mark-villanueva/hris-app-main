<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->decimal('daily_rate', 8, 2);
            $table->decimal('hourly_rate', 8, 2);
            $table->decimal('bir', 8, 2);
            $table->decimal('sss', 8, 2);
            $table->decimal('philhealth', 8, 2);
            $table->decimal('pagibig', 8, 2);
            $table->decimal('ot_rate', 8, 2);
            $table->decimal('nta', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
