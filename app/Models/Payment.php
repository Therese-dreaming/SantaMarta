<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_booking_id',
        'amount',
        'payment_method',
        'reference_number',
        'payment_proof',
        'verified_by',
        'verified_at',
        'verification_notes',
    ];

    /**
     * Get the booking that owns the payment.
     */
    public function booking()
    {
        return $this->belongsTo(ServiceBooking::class, 'service_booking_id');
    }

    /**
     * Get the user who verified the payment.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
} 