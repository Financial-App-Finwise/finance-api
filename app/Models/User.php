<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function parentcategories(){
        //return $this->hasMany(Category::class);
        return $this->hasMany(ParentCategory::class, 'userID');
    }
    public function categories(){
        //return $this->hasMany(Category::class);
        return $this->hasMany(Category::class, 'userID');
    }
    public function goals(){
        return $this->hasMany(Goal::class);
    }
    public function upcomingbills(){
        return $this->hasMany(UpcomingBill::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
