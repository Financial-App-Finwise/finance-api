<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiSession extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'api_token',
        'device_type'
    ];
}
