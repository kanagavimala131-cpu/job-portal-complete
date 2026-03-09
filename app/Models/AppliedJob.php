<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedJob extends Model
{
    use HasFactory;

    protected $table = 'applied_jobs';
    
    protected $fillable = [
        'user_id',
        'job_title',
        'company',
        'location',
        'salary',
        'status',
        'applied_date',
        'notes'
    ];

    protected $casts = [
        'applied_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}