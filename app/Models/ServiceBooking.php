<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServiceBooking extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['service_color', 'service_icon'];

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
        'cancelled_by',
        'priest_id'
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

    /**
     * Get the documents for the booking.
     */
    public function documents()
    {
        return $this->hasMany(ServiceDocument::class, 'service_booking_id');
    }

    public function priest(): BelongsTo
    {
        return $this->belongsTo(Priest::class);
    }

    /**
     * Get the service color attribute based on the booking type.
     *
     * @return string
     */
    public function getServiceColorAttribute()
    {
        switch ($this->type) {
            case 'baptism':
                return 'sky';
            case 'wedding':
                return 'rose';
            case 'mass_intention':
                return 'indigo';
            case 'blessing':
                return 'amber';
            case 'confirmation':
                return 'emerald';
            case 'sick_call':
                return 'red';
            default:
                return 'gray';
        }
    }

    /**
     * Get the service icon attribute based on the booking type.
     *
     * @return string
     */
    public function getServiceIconAttribute()
    {
        switch ($this->type) {
            case 'baptism':
                return 'fas fa-water';
            case 'wedding':
                return 'fas fa-rings-wedding';
            case 'mass_intention':
                return 'fas fa-church';
            case 'blessing':
                return 'fas fa-hands-praying';
            case 'confirmation':
                return 'fas fa-dove';
            case 'sick_call':
                return 'fas fa-hospital-user';
            default:
                return 'fas fa-circle';
        }
    }
}
