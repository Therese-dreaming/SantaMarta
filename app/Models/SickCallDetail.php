<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SickCallDetail extends Model
{
    protected $fillable = [
        'service_booking_id',
        'patient_name',
        'patient_age',
        'patient_condition',
        'location',
        'room_number',
        'contact_person',
        'emergency_contact'
    ];

    public function serviceBooking(): BelongsTo
    {
        return $this->belongsTo(ServiceBooking::class);
    }
}