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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('gender');
            $table->date('birth_date');
            $table->string('civil_status');
            $table->string('mobile_number');
            $table->string('email');
            $table->string('address');
            $table->string('tin')->nullable();  
            $table->string('sss')->nullable();  
            $table->string('philhealth')->nullable();  
            $table->string('pagibig')->nullable(); 
            $table->string('contact_name');
            $table->string('contact_number');
            $table->string('relationship');
            $table->foreignId('departments_id')->constrained('departments')->cascadeOnDelete()->nullable(); 
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->nullable(); 
            $table->foreignId('positions_id')->constrained('positions')->cascadeOnDelete()->nullable();
            $table->string('description');
            $table->foreignId('salary_id')->constrained('salaries')->cascadeOnDelete()->nullable(); 
            $table->string('status')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
