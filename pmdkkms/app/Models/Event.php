<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // These are the fields that can be mass-assigned
    protected $fillable = ['title', 'event_date', 'start_time', 'end_time', 'location', 'color'];

    // Ensure event_date is treated as a date when retrieved
    protected $casts = [
        'event_date' => 'date',
    ];
}
