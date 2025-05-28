<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('service_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('service_booking_id')->nullable()->after('user_id');
            $table->foreign('service_booking_id')->references('id')->on('service_bookings')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('service_documents', function (Blueprint $table) {
            $table->dropForeign(['service_booking_id']);
            $table->dropColumn('service_booking_id');
        });
    }
};
