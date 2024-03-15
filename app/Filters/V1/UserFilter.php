<?php

namespace App\Filters\V1;
use Illuminate\HTTP\Request;  

use App\Filters\ApiFilter;


class UserFilter extends ApiFilter{

    protected $allowedParms = [
        'name' => ['eq'],
        'email' => ['eq'],
    ];

    // protected $columnMap = [
    //     'name' => 'name',
    //     'createdAt' => ['created_at'],
    //     'updatedAt' => ['updated_at'],
    // ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        //the in and like operator can also be used
    ];

    // I just test the function below to see if the filter works fine but we don't need it
    // public function transform(Request $request)
    // {
    //     $eloQuery = [];

    //     foreach ($this->allowedParms as $parm => $operators) {
    //         $query = $request->query($parm);

    //         if (!isset($query)) {
    //             continue;
    //         }

    //         $column = $this->columnMap[$operators[0]] ?? $parm;

    //         foreach ($operators as $operator) {
    //             if (isset($query[$operator])) {
    //                 $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
    //             }
    //         }
    //     }

    //     return $eloQuery;
    // }
}