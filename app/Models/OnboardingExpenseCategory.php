<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnboardingExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'onboardingID',
        'categoryID',
        'parentID',
        'amount'
    ];

    public function onboarding()
    {
        return $this->belongsTo(UserOnboardingInfo::class, 'onboardingID');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID');
    }
}
