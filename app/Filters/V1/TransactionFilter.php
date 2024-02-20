<?php

namespace App\Filters\V1;
use Illuminate\HTTP\Request;

use App\Filters\ApiFilter;


class TransactionFilter extends ApiFilter{

    protected $allowedParms = [
        'categoryID' => ['eq', 'ne'],
        'isIncome' => ['eq', 'ne'],
        'amount' => ['eq', 'lt', 'lte', 'gt', 'gte', 'ne'],
        'hasContributed' => ['eq', 'ne'],
        'upcomingbillID' => ['eq', 'ne'],
        'budgetplanID' => ['eq', 'ne'],
        'expenseType' => ['eq', 'ne'],
        'date' => ['eq', 'lt', 'lte', 'gt', 'gte', 'ne'],
        'note' => ['eq', 'ne'],
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