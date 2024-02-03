<?php

namespace App\Services\V1;
use Illuminate\HTTP\Request;

class CategoryQuery{
    protected $allowedParms = [
        'name' => ['eq'],
        'email' => ['eq'],
        'email_verified_at' => ['eq'],
        'password' => ['eq'],
        'created_at' => ['eq'],
        'updated_at' => ['eq'],
    ];

    protected $columnMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '=<',
        'gt' => '>',
        'gte' => '>=',
    ];

    }