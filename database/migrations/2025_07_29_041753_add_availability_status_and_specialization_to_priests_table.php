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
        Schema::table('priests', function (Blueprint $table) {
            $table->string('specialization')->nullable()->after('phone');
            $table->boolean('availability_status')->default(true)->after('specialization');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('priests', function (Blueprint $table) {
            $table->dropColumn(['specialization', 'availability_status']);
        });
    }
};
