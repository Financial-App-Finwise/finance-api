<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionGoal extends Model
{
    use HasFactory;
    protected $fillable = [
        'userID',
        'transactionID',
        'goalID',
        'ContributionAmount',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function goal()
    {
        return $this->belongsTo(Goal::class, 'goalID');
    }
}
