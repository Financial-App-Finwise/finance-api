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
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function UpcomingBill(){
        return $this->belongsTo(UpcomingBill::class);
    }
}
