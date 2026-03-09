<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortlistedJob extends Model
{
    use HasFactory;

    protected $table = 'shortlisted_jobs';
    
    protected $fillable = [
        'user_id',
        'job_title',
        'company',
        'location',
        'salary',
        'job_type',
        'shortlisted_date'
    ];

    protected $casts = [
        'shortlisted_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}