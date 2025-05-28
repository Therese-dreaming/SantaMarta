<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'type',
        'date',
        'start_time',
        'end_time',
        'description',
        'recurrence',
        'block_bookings',
        'created_by_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'block_bookings' => 'boolean',
    ];

    /**
     * Get formatted start time.
     *
     * @return string
     */
    public function getFormattedStartTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->start_time)->format('g:i A');
    }

    /**
     * Get formatted end time.
     *
     * @return string
     */
    public function getFormattedEndTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->end_time)->format('g:i A');
    }

    /**
     * Check if this activity conflicts with a given time range.
     *
     * @param string $date
     * @param string $startTime
     * @param string $endTime
     * @return bool
     */
    public function conflictsWith($date, $startTime, $endTime)
    {
        if ($this->date->format('Y-m-d') !== $date) {
            return false;
        }

        $activityStart = strtotime($this->start_time);
        $activityEnd = strtotime($this->end_time);
        $checkStart = strtotime($startTime);
        $checkEnd = strtotime($endTime);

        return (
            ($checkStart >= $activityStart && $checkStart < $activityEnd) ||
            ($checkEnd > $activityStart && $checkEnd <= $activityEnd) ||
            ($checkStart <= $activityStart && $checkEnd >= $activityEnd)
        );
    }

    /**
     * Get the user who created this activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
