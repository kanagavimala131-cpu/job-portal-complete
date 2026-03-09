<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvFile extends Model
{
    use HasFactory;

    protected $table = 'cv_files';
    
    protected $fillable = [
        'user_id',
        'filename',
        'original_name',
        'file_path',
        'file_size',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}