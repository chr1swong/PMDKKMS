<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    // Allow mass assignment of these fields, including set totals
    protected $fillable = [
        'membership_id', 
        'distance', 
        'date', 

        // Scores for each set
        'set1_score1', 'set1_score2', 'set1_score3', 
        'set1_score4', 'set1_score5', 'set1_score6', 
        'set2_score1', 'set2_score2', 'set2_score3', 
        'set2_score4', 'set2_score5', 'set2_score6', 
        'set3_score1', 'set3_score2', 'set3_score3', 
        'set3_score4', 'set3_score5', 'set3_score6', 
        'set4_score1', 'set4_score2', 'set4_score3', 
        'set4_score4', 'set4_score5', 'set4_score6', 
        'set5_score1', 'set5_score2', 'set5_score3', 
        'set5_score4', 'set5_score5', 'set5_score6', 
        'set6_score1', 'set6_score2', 'set6_score3', 
        'set6_score4', 'set6_score5', 'set6_score6', 

        // Set totals
        'set1_total', 
        'set2_total', 
        'set3_total', 
        'set4_total', 
        'set5_total', 
        'set6_total', 

        // Overall total and counters
        'overall_total', 
        'x_count', 
        'ten_count', 
        'x_and_ten_count', 

        'notes'
    ];

    // Define the relationship with the Membership model
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'membership_id');
    }
}
