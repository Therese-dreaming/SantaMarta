<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceDocument extends Model
{
    protected $fillable = [
        'user_id',
        'service_type',
        'service_booking_id',
        'document_type',
        'file_path',
        'status',
        'verification_notes',
        'verified_at',
        'verified_by'
    ];

    protected $casts = [
        'verified_at' => 'datetime'
    ];

    /**
     * Get the user that owns the document.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the verifier of the document.
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
    
    public function serviceBooking()
    {
        return $this->belongsTo(ServiceBooking::class, 'service_booking_id');
    }
}