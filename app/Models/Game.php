<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Game extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'pin',
        'ip',
        'api_key_id'
    ];

    public function apiKey()
    {
        return $this->belongsTo(ApiKey::class);
    }
}
