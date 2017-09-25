<?php

namespace App\Http\Controllers\GraphQL\Table;

use GraphQL as Graph;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use function GuzzleHttp\Psr7\str;
use Illuminate\Support\Facades\DB;

class TableInfo extends Query
{
    protected $attributes = [
        'name' => 'tables'
    ];


    public function type()
    {
        return Type::listOf(Graph::type('table'));
    }

    public function args()
    {
        return [
            'table_id' => ['name' => 'table_id', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args)
    {
//        dd($args);
        $tableId = $args['table_id'];
        if($res = DB::collection('action_table_define')->where(['_id'=>$tableId,'is_del'=>0])->first()) {
            $tableFields = $res['table_fields'];
            foreach ($tableFields as $k => $v) {
                $tableFields[$k]['fid'] = (string) $v['fid'];
            }
            $data[0]['id'] = $tableId;
            $data[0]['fields_info'] = $tableFields;
            return $data;
        } 
        return null;
    }

}
