<?php

namespace App\Http\Controllers\GraphQL\Table;

use GraphQL as Graph;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\DB;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\EnumType;
use GraphQL\Type\Definition\ObjectType;
use MongoDB\BSON\ObjectID;

class UpdateTable extends Mutation
{
    protected $attributes = [
        'name' => 'updateTable'
    ];

    public function type()
    {
//        echo 'aa';
        return Type::listOf(Graph::type('table'));
    }

    public function args()
    {
//        echo 'bb';
//        $typeModel = new TableType();
//        $typeModel->typeName = $this->attributes['name'];
//        dd($this->attributes['name']);

        $filters = new InputObjectType([
            'name' => 'fieldUpdate',
            'fields' => [
                'fid' => [
                    'type' => Type::string(),
                ],
                'fname' => [
                    'type' => Type::string(),
                ],
                'ftype' => [
                    'type' => Type::string(),
                ]
            ]
        ]);

        $tableEnum = new EnumType([
            'name' => 'tableUpType',
            'values' => [
                'UPDATE' => [
                    'value' => 0,
                ],
                'DELLETE' => [
                    'value' => 1,
                ],
                'ADD' => [
                    'value' => 2,
                ],
            ]
        ]);

        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => "tableID"
            ],
            'type' => [
                'type' => Type::nonNull($tableEnum),
                'description' => "update type"
            ],
            'fields' => [
                'type' => Type::nonNull(Type::listOf($filters)),
                'description' => "the table fields"
            ],
        ];
    }

    public function resolve($root, $args)
    {
//        echo 'cc';
//        dd($args);
        $upType = $args['type'];
        $tableId = $args['id'];

        try {
            $fields = $args['fields'];

            if(DB::collection("data_".$tableId)->count() === 0) {
                // 获取原有字段
                $tableInfo = DB::collection('action_table_define')->select('table_fields')->where('_id', $tableId)->first();
                $tableFilds = $tableInfo['table_fields'];
                if ($upType === 3) {
                    foreach ($fields as $m => $n) {
                        $newField['fid'] = new ObjectID();
                        $newField['fname'] = $n['fname'];
                        $newField['ftype'] = $n['ftype'];
                        $tableFilds[] = $newField;
                    }
                } else {
                    foreach ($tableFilds as $k => $v) {
                        foreach ($fields as $x => $y) {
                            if ($v['fid'] == $y['fid']) {
                                if ($upType === 0) {
                                    $tableFilds[$k]['fname'] = $y['fname'];
                                    $tableFilds[$k]['ftype'] = $y['ftype'];
                                } else {
                                    unset($tableFilds[$k]);
                                }
                            }
                        }
                    }

                }

//            dd($tableFilds);
                if (DB::collection('action_table_define')->where('_id', $tableId)->update(['table_fields' => $tableFilds, 'update_time' => time()])) {
                    $back[0]['errcode'] = 0;
                    $back[0]['errmsg'] = 'success';
                    $back[0]['info'] = 'success';
                } else {
                    $back[0]['errcode'] = -1;
                    $back[0]['errmsg'] = 'error';
                    $back[0]['info'] = 'error';
                }
            } else {
                $back[0]['errcode'] = -1;
                $back[0]['errmsg'] = 'error';
                $back[0]['info'] = 'error';
            }
            return $back;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $message;
        }


    }
}
