<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'event_date', 'start_time', 'end_time', 'location'];

    // Ensure event_date is cast as a date
    protected $casts = [
        'event_date' => 'date',
    ];
}
