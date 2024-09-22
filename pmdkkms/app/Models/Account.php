<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'account';
    protected $primaryKey = 'account_id';
    public $timestamps = false;  // Set to false if not needed, can change in the future

    protected $fillable = [
        'account_full_name',
        'account_email_address',
        'account_password',
        'account_role',
        'account_contact_number',
        'account_membership_status',
        'account_membership_expiry',
        'account_profile_picture_path',
    ];

    protected $hidden = [
        'account_password',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'account_password' => 'hashed',
        ];
    }

    // Override method to get email address for password reset
    public function getEmailForPasswordReset() {
        return $this->account_email_address;
    }

    // Define the email attribute to satisfy the password reset broker
    public function getEmailAttribute() {
        return $this->account_email_address;
    }

    // Define relationship: a coach can have many archers
    public function archers()
    {
        return $this->belongsToMany(Account::class, 'coach_archer', 'coach_id', 'archer_id')
                    ->withTimestamps()
                    ->where('account_role', 1); // Assuming role '1' is Archer
    }

    // Define relationship: an archer can have one coach
    public function coach()
    {
        return $this->belongsToMany(Account::class, 'coach_archer', 'archer_id', 'coach_id')
                    ->withTimestamps()
                    ->where('account_role', 2); // Assuming role '2' is Coach
    }

    // Add relationship to Membership (if you want to fetch membership details easily)
    public function membership()
    {
        return $this->hasOne(Membership::class, 'account_id', 'account_id');
    }
}
