<?php

namespace App\Http\Controllers\GraphQL\Table;

use GraphQL as Graph;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\DB;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use Mockery\Exception;


class DeleteTable extends Mutation
{
    protected $attributes = [
        'name' => 'deleteTable'
    ];

    public function type()
    {
//        echo 888;
        return Type::listOf(Graph::type('table'));
    }

    public function args()
    {
//        echo 999;
//        $typeModel = new TableType();
//        $typeModel->typeName = $this->attributes['name'];
//        dd($this->attributes['name']);

        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => "tableID"
            ],
        ];
    }

    public function resolve($root, $args)
    {
//        echo 000;
//        dd($args);
        $tableId = $args['id'];   # tableId
        try{
            $tableName = "data_" . $tableId;
            if (DB::collection($tableName)->count() === 0) {
                if(DB::collection('action_table_define')->where('_id',$tableId)->update(['is_del'=>1])) {
                    $back[0]['errcode'] = 0;
                    $back[0]['errmsg'] = 'success';
                } else {
                    $back[0]['errcode'] = -1;
                    $back[0]['errmsg'] = 'error';
                }
            } else {
                $back[0]['errcode'] = -2;
                $back[0]['errmsg'] = '表中存在数据不可删除';
            }
            return $back;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $message;
        }

    }





}
