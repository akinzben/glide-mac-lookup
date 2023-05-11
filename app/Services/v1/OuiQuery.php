<?php

namespace App\Services\v1;

use Illuminate\Http\Request;

class OuiQuery {

    protected $safeParms = [
        'Assignment' => ['eq'],
        'Organization_name' => ['eq']
    ];

    protected $columnMap = [
        'Assignment' => 'Assignment'
    ];

    protected $operatorMap = [
        'eq' => '='
    ];

    public function transform(Request $request) {
        $eloQuery = [];

        foreach ($this->safeParms as $parm => $operators) {
            $query = $request->query($parm);

            if(!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if(isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }



        return $eloQuery;
    }

}