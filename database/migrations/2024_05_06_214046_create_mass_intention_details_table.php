<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mass_intention_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_booking_id')->constrained()->onDelete('cascade');
            $table->string('mass_type');
            $table->text('mass_names');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mass_intention_details');
    }
};