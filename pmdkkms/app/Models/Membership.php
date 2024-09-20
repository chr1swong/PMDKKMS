<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'membership'; // Table name

    protected $primaryKey = 'membership_id'; // Primary key is 'membership_id'

    public $incrementing = false; // Set to false since membership_id is not auto-incrementing

    protected $keyType = 'string'; // Since membership_id is a string

    protected $fillable = [
        'membership_id',
        'account_id',
        'membership_expiry',
        'membership_status',
    ];

    // Define the relationship to the Account model
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'account_id');
    }
}

