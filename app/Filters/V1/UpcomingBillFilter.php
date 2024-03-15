<?php

namespace App\Filters\V1;
use Illuminate\HTTP\Request;

use App\Filters\ApiFilter;


class UpcomingBillFilter extends ApiFilter{

    protected $allowedParms = [
        //'userID' => ['eq'],
        'categoryID' => ['eq'],
        'amount' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'date' => ['eq', 'lt', 'gt', 'lte', 'gte'],
        'name' => ['eq', 'ne'],
        'note' => ['eq', 'ne'],
        'status' => ['eq'],

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
