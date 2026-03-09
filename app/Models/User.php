<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'login_credentials';
    
    protected $fillable = [
        'email',
        'password',
        'remember_token',
        'last_login',
        'login_attempts',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function personalDetails()
    {
        return $this->hasOne(UserPersonalDetail::class, 'user_id');
    }

    public function shortlistedJobs()
    {
        return $this->hasMany(ShortlistedJob::class, 'user_id');
    }

    public function appliedJobs()
    {
        return $this->hasMany(AppliedJob::class, 'user_id');
    }

    public function jobAlerts()
    {
        return $this->hasMany(JobAlert::class, 'user_id');
    }

    public function cvFiles()
    {
        return $this->hasMany(CvFile::class, 'user_id');
    }
}