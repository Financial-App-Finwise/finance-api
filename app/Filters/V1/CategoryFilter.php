<?php

namespace App\Filters\V1;
use Illuminate\HTTP\Request;

use App\Filters\ApiFilter;


class CategoryFilter extends ApiFilter{

    protected $allowedParms = [
        'userID' => ['eq'],
        'name' => ['eq', 'ne'],
        'isIncome' => ['eq', 'ne'],
        'parentID' => ['eq'],
        'level' => ['eq', 'ne'],
        'isOnboarding' => ['eq', 'ne'],
    ];
    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'ne' => '!=',
    ];
}