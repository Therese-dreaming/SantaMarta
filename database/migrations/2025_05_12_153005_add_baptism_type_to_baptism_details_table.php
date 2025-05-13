<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('baptism_details', function (Blueprint $table) {
            $table->string('baptism_type')->after('service_booking_id');
        });
    }

    public function down()
    {
        Schema::table('baptism_details', function (Blueprint $table) {
            $table->dropColumn('baptism_type');
        });
    }
};
