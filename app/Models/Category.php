<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'isIncome',
        'parentID',
        'level',
        'isOnbaording',
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    // public function categories()
    // {
    //     return $this->belongsTo(Category::class, 'parentID');
    // }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parentID');
    }
    //The belongsTo relationship helps you easily retrieve the parent category of a given category.
    //if you have a category instance $childCategory, you can use $childCategory->parent to get the parent category of that child category.

    public function children()
    {
        return $this->hasMany(Category::class, 'parentID');
    }
}

