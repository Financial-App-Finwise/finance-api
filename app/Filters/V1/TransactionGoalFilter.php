<?php

namespace App\Filters\V1;
use Illuminate\HTTP\Request;

use App\Filters\ApiFilter;


class TransactionGoalFilter extends ApiFilter{

    protected $allowedParms = [
        'transactionID' => ['eq', 'ne'],
        'goalID' => ['eq', 'ne'],
        'ContributionAmount' => ['eq', 'lt', 'lte', 'gt', 'gte', 'ne'],
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