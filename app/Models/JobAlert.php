<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAlert extends Model
{
    use HasFactory;

    protected $table = 'job_alerts';
    
    protected $fillable = [
        'user_id',
        'title',
        'keywords',
        'frequency',
        'location',
        'min_salary',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}