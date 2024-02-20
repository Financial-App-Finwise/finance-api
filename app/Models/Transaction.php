<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'categoryID',
        'isIncome',
        'amount',
        'hasContributed',
        'upcomingbillID',
        'budgetplanID',
        'expenseType',
        'date',
        'note',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

