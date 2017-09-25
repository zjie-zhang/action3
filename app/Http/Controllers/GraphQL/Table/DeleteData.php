<?php

namespace App\Http\Controllers\GraphQL\Table;

use GraphQL as Graph;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\DB;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use Mockery\Exception;

class DeleteData extends Mutation
{
    protected $attributes = [
        'name' => 'deleteData'
    ];

    public function type()
    {
        return Type::listOf(Graph::type('data'));
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => "dataID"
            ],
            'table_id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => "tableID"
            ],
        ];
    }

    public function resolve($root, $args)
    {
//        dd($args);
        $dataId = $args['id'];   # dataId
        $tableIdId = $args['table_id'];   # dataId
        $tableName = "data_" . $tableIdId;
//        dd($tableName);
        try{
            if(DB::collection($tableName)->where('_id',$dataId)->delete()) {
                $back[0]['errcode'] = 0;
                $back[0]['errmsg'] = 'success';
            } else {
                $back[0]['errcode'] = -1;
                $back[0]['errmsg'] = 'error';
            }
            return $back;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $message;
        }

    }

}
