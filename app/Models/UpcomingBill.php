<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpcomingBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'categoryID',
        'amount',
        'date',
        'name',
        'note',
    ];
    
    protected $casts = [
        'date' => 'datetime',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function upcomingbill(){
        return $this->belongsTo(Goal::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID');
    }
}
