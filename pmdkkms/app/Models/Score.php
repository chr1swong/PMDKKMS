<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_id', 'set', 'category', 'distance', 'date', 'score1', 'score2', 'score3', 'score4', 'score5', 'score6', 'total', 'notes'
    ];

    // Define the relationship with the membership
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'membership_id');
    }
}
