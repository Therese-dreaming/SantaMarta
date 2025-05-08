<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_booking_id')->constrained()->onDelete('cascade');
            $table->string('groom_name');
            $table->integer('groom_age');
            $table->string('groom_religion');
            $table->string('bride_name');
            $table->integer('bride_age');
            $table->string('bride_religion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_details');
    }
};