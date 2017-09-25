<?php

namespace App\Http\Controllers\GraphQL\Table;

use GraphQL as Graph;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Illuminate\Support\Facades\DB;

class Tables extends Query
{
    protected $attributes = [
        'name' => 'tables'
    ];


    public function type()
    {
//        echo 222;
        return Type::listOf(Graph::type('table'));
    }

    public function args()
    {
//        echo 333;
//        $typeModel = new TableType();
//        $typeModel->typeName = $this->attributes['name'];
//        dd($this->attributes['name']);
        return [
            'app_id' => ['name' => 'app_id', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args)
    {
//        echo 444;
        $appId = $args['app_id'];
        if($res = DB::collection('action_table_define')->where(['app_id'=>$appId,'is_del'=>0])->get()->toArray()) {
            foreach ($res as $k => $v) {
                $rowNum = DB::collection("data_".$v['_id'])->count();
                $data[$k]['id'] = (string)$v['_id'];
                $data[$k]['name'] = (string)$v['table_name'];
                $data[$k]['column_num'] = count($v['table_fields']);
                $data[$k]['row_num'] = $rowNum;
                $data[$k]['create_time'] = $v['create_time'];
                $data[$k]['update_time'] = $v['update_time'];
            }
            return $data;
        }
        return null;
    }



}
