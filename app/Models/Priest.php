<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Priest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialization',
        'availability_status',
        'notes'
    ];

    protected $casts = [
        'availability_status' => 'boolean',
    ];

    /**
     * Get the service bookings for the priest.
     */
    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }

    /**
     * Scope a query to only include available priests.
     */
    public function scopeAvailable($query)
    {
        return $query->where('availability_status', true);
    }

    /**
     * Get the priest's full contact information.
     */
    public function getFullContactAttribute()
    {
        $contact = $this->name;
        if ($this->email) {
            $contact .= ' (' . $this->email . ')';
        }
        if ($this->phone) {
            $contact .= ' - ' . $this->phone;
        }
        return $contact;
    }
}
