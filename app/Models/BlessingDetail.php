<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlessingDetail extends Model
{
    protected $fillable = [
        'service_booking_id',
        'blessing_type',
        'blessing_location'
    ];

    public function serviceBooking(): BelongsTo
    {
        return $this->belongsTo(ServiceBooking::class);
    }
}