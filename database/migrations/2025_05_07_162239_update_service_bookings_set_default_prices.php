<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ServiceBooking;

return new class extends Migration
{
    public function up()
    {
        $servicePrices = [
            'baptism' => 1000.00,
            'wedding' => 5000.00,
            'mass_intention' => 500.00,
            'blessing' => 1500.00,
            'confirmation' => 1000.00,
            'sick_call' => 1000.00
        ];

        foreach ($servicePrices as $type => $price) {
            ServiceBooking::where('type', $type)
                ->where('amount', 0)
                ->update(['amount' => $price]);
        }
    }

    public function down()
    {
        // No need for rollback as this is data correction
    }
};