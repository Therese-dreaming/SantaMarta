<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingDetail extends Model
{
    protected $fillable = [
        'service_booking_id',
        'groom_name',
        'groom_age',
        'groom_religion',
        'bride_name',
        'bride_age',
        'bride_religion'
    ];

    public function serviceBooking(): BelongsTo
    {
        return $this->belongsTo(ServiceBooking::class);
    }
}