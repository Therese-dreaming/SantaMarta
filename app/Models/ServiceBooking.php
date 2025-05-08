<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServiceBooking extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'ticket_number',
        'preferred_date',
        'preferred_time',
        'notes',
        'status',
        'payment_status',
        'payment_method',
        'payment_reference',
        'payment_proof',
        'amount',
        'paid_at',
        // Add these new fields
        'verification_status',
        'verification_notes',
        'verified_at',
        'verified_by',
        'approved_at',
        'approved_by',
        'cancelled_at',
        'cancelled_by'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function baptismDetail(): HasOne
    {
        return $this->hasOne(BaptismDetail::class);
    }

    public function weddingDetail(): HasOne
    {
        return $this->hasOne(WeddingDetail::class);
    }

    public function confirmationDetail(): HasOne
    {
        return $this->hasOne(ConfirmationDetail::class);
    }

    public function blessingDetail(): HasOne
    {
        return $this->hasOne(BlessingDetail::class);
    }

    public function massIntentionDetail(): HasOne
    {
        return $this->hasOne(MassIntentionDetail::class);
    }

    public function sickCallDetail(): HasOne
    {
        return $this->hasOne(SickCallDetail::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
