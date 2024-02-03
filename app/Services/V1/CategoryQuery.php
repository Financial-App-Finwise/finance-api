<?php

namespace App\Services\V1;
use Illuminate\HTTP\Request;

class CategoryQuery{
    protected $allowedParams = [
        'userID' => ['eq'],
        'name' => ['eq'],
        'isIncome' => ['eq'],
        'parentID' => ['eq'],
        'level' => ['eq'],
        'isOnboarding' => ['eq'],
        //'created_at' => $this->created_at,
        //'updated_at' => $this->updated_at,
    ];
}