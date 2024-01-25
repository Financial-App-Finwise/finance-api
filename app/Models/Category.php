<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // public function user(){
    //     return $this->belongsTo(User::class);
    // }
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'parentID');
    }

    // public function children()
    // {
    //     return $this->hasMany(Category::class, 'parentID');
    // }
}

