<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyFinance extends Model
{
    use HasFactory;

    protected $fillable = [
        'sessionID',
        'userID',
        'totalbalance',
        'currencyID',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currencyID');
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['totalbalance'] = (float) $array['totalbalance'];

        return $array;
    }
}
