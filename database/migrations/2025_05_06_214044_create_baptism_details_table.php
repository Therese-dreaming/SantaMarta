<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baptism_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_booking_id')->constrained()->onDelete('cascade');
            $table->string('child_name');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('nationality');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baptism_details');
    }
};