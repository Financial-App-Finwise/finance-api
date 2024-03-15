<?php

namespace App\Filters\V1;
use Illuminate\HTTP\Request;

use App\Filters\ApiFilter;


class GoalFilter extends ApiFilter{

    protected $allowedParms = [
        //'userID' => ['eq'],
        'name' => ['eq', 'ne'],
        'amount' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'currentSave' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'remainingSave' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'setDate' => ['eq', 'ne'],
        'startDate' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'endDate' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'monthlyContribution' => ['eq', 'lt', 'gt', 'lte', 'gte'],
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

   