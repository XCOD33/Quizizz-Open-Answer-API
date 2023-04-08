<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_key',
        'max_hit',
        'hit_count',
        'created_at',
        'last_reset_date'
    ];

    public $timestamps = false;
}
