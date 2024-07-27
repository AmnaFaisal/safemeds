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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->STRING('gender');
            $table->integer('age');
            $table->string('blood_group');
            $table->string('marital_status');
            $table->string('address');
            $table->string('contact_number');
            $table->text('patient_diagnose');
            $table->text('past_illness');
            $table->text('past_surgeries');
            $table->text('allergic');
            $table->string('primary_care_physician');
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
