<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sick_call_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_booking_id')->constrained()->onDelete('cascade');
            $table->string('patient_name');
            $table->integer('patient_age');
            $table->text('patient_condition');
            $table->string('location');
            $table->string('room_number');
            $table->string('contact_person');
            $table->string('emergency_contact');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sick_call_details');
    }
};