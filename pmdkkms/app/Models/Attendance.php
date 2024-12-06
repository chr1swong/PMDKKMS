<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'membership_id', 
        'attendance_date', 
        'attendance_status',
        'check_in_time',
        'session',  
    ];

    // Define relationship with membership
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'membership_id');
    }
}
