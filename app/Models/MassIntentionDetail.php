<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MassIntentionDetail extends Model
{
    protected $fillable = [
        'service_booking_id',
        'mass_type',
        'mass_names'
    ];

    public function serviceBooking(): BelongsTo
    {
        return $this->belongsTo(ServiceBooking::class);
    }
}