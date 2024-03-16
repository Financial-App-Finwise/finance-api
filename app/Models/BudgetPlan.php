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
        'date',
        'isRecurring'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'budgetplanID');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID');
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['amount'] = (float) $array['amount'];
        return $array;
    }
}

