<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('confirmation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_booking_id')->constrained()->onDelete('cascade');
            $table->string('confirmand_name');
            $table->date('confirmand_dob');
            $table->string('baptism_place');
            $table->date('baptism_date');
            $table->string('sponsor_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('confirmation_details');
    }
};