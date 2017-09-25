<?php

namespace App\Http\Controllers\GraphQL\Table;

use GraphQL as Graph;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\DB;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use MongoDB\BSON\ObjectID;


class CreateData extends Mutation
{
    protected $attributes = [
        'name' => 'createData'
    ];

    public function type()
    {
        return Type::listOf(Graph::type('data'));
//        return Graph::type('data');
    }

    public function args()
    {
//        echo "zzz";
        $dataFilters = new InputObjectType([
            'name' => 'dataInput',
            'fields' => [
                'fid' => [
                    'type' => Type::string(),
                ],
                'fvalue' => [
                    'type' => Type::string(),
                ]
            ]
        ]);

        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'datas' => [
                'type' => Type::nonNull(Type::listOf($dataFilters)),
            ],
        ];


    }

    public function resolve($root, $args)
    {
        $fNew = array();
        $inData = array();
        $tableId = $args['id'];
        $tbDatas = $args['datas'];
        $tableName = "data_" . $tableId;
        if (count($tbDatas)) {
            // 获取表字段
            $tableInfo = DB::collection('action_table_define')->select('table_fields')->where('_id', $tableId)->first();
            $tableFilds = $tableInfo['table_fields'];
            foreach ($tableFilds as $k => $v) {
                $fid = (string)$v['fid'];
                $fids[] = $v['fid'];
                $fNew[$fid]['fname'] = $v['fname'];
                $fNew[$fid]['ftype'] = $v['ftype'];
            }

            foreach ($tbDatas as $dk => $dv) {
                $dfId = $dv['fid'];
                $dfValue = $dv['fvalue'];
//                dd(in_array($dfId, $fids));
                if (in_array($dfId, $fids)) {
                    $dfType = $fNew[$dfId]['ftype'];
                    if ($dfType == 'int') {
                        $dfValue = (int)$dfValue;
                    } elseif ($dfType == 'string') {
                        $dfValue = (string)$dfValue;
                    } elseif ($dfType == 'time') {
                        $dfValue = date("Y-m-d H:i:s", strtotime($dfValue));
                    }
                    $inData[$dfId] = $dfValue;
                }
            }
//            dd($inData);
            if (count($inData)) {
                DB::collection($tableName)->insert($inData);
                $back[0]['errcode'] = 0;
                $back[0]['errmsg'] = 'success';
                return $back;
            }

        }


    }
}
