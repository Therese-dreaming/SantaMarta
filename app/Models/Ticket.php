<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'subject_type',
        'other_subject',
        'message',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}