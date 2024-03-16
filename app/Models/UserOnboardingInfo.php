<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOnboardingInfo extends Model
{
    use HasFactory;
    protected $table = 'users_onboarding_info';

    protected $fillable = [
        'userID',
        'gender',
        'age',
        'marital_status',
        'life_stage',
        'daily_expense',
        'weekly_expense',
        'monthly_expense',
        'daily_income',
        'weekly_income',
        'monthly_income',
        'financial_goal',
        'dream_amount',
        'envision_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function onboardingExpenseCategories()
    {
        return $this->hasMany(OnboardingExpenseCategory::class, 'onboardingID');
    }
}
