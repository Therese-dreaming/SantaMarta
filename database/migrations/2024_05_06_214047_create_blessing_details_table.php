<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blessing_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_booking_id')->constrained()->onDelete('cascade');
            $table->string('blessing_type');
            $table->string('blessing_location');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blessing_details');
    }
};