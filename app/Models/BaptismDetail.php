<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BaptismDetail extends Model
{
    protected $fillable = [
        'service_booking_id',
        'child_name',
        'date_of_birth',
        'place_of_birth',
        'father_name',
        'mother_name',
        'nationality'
    ];

    public function serviceBooking(): BelongsTo
    {
        return $this->belongsTo(ServiceBooking::class);
    }
}