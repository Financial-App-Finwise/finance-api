<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verification_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

public function getJWTIdentifier()
{
    return $this->getKey();
}

public function getJWTCustomClaims()
{
    return [];
}
}

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