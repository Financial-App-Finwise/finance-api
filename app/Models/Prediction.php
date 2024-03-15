<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID', 
        'predicted_budget'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
