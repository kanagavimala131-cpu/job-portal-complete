<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPersonalDetail extends Model
{
    use HasFactory;

    protected $table = 'user_personal_details';
    
    protected $fillable = [
        'user_id',
        'fullname',
        'date_of_birth',
        'gender',
        'work_status',
        'total_experience_years',
        'total_experience_months',
        'current_salary',
        'notice_period',
        'phone',
        'email',
        'profile_photo',
        'skills_percentage',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'current_city',
        'current_area'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'current_salary' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}