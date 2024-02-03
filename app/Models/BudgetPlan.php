<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'categoryID',
        'isMonthly',
        'name',
        'amount',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

