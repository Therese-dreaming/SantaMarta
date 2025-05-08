<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfirmationDetail extends Model
{
    protected $fillable = [
        'service_booking_id',
        'confirmand_name',
        'confirmand_dob',
        'baptism_place',
        'baptism_date',
        'sponsor_name'
    ];

    public function serviceBooking(): BelongsTo
    {
        return $this->belongsTo(ServiceBooking::class);
    }
}