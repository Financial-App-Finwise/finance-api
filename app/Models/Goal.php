<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'name',
        'amount',
        'currentSave',
        'remainingSave',
        'setDate',
        'startDate',
        'endDate',
        'monthlyContribution',
        'created_at',
        'updated_at',
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function goal(){
        return $this->belongsTo(Goal::class);
    }
    public function transactiongoal(){
        return $this->hasMany(TransactionGoal::class);
    }
}
