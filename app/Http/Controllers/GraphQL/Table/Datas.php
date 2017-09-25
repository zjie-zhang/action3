<?php

namespace App\Http\Controllers\GraphQL\Table;

use GraphQL as Graph;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Illuminate\Support\Facades\DB;

class Datas extends Query
{
    protected $attributes = [
        'name' => 'datas'
    ];


    public function type()
    {
        return Type::listOf(Graph::type('data'));
    }

    public function args()
    {
        return [
            'table_id' => ['name' => 'table_id', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args)
    {
        $back = array();
        $fids = array();
        $fNew = array();
        $dataInfo = array();
        $tableId = $args['table_id'];
        $tableName = "data_" . $tableId;
        if($tableInfo = DB::collection('action_table_define')->where(['_id'=>$tableId,'is_del'=>0])->first()) {
            $tableFilds = $tableInfo['table_fields'];
            foreach ($tableFilds as $k => $v) {
                $fid = (string)$v['fid'];
                $fids[] = $v['fid'];
                $fNew[$fid]['fname'] = $v['fname'];
                $fNew[$fid]['ftype'] = $v['ftype'];
            }
            $back[0]['id'] = $tableId;
            $dataArr = DB::collection($tableName)->get()->toArray();
            foreach ($dataArr as $dk => $dv) {
                $dataId = (string)$dv['_id'];
                $data[$dk]['data_id'] = $dataId;
                foreach ($fids as $fk => $fid) {
                    $fid = (string) $fid;
                    $dataInfo[$fk]['fid'] = $fid;
                    $dataInfo[$fk]['fname'] = $fNew[$fid]['fname'];
                    $dataInfo[$fk]['ftype'] = $fNew[$fid]['ftype'];
                    $dataInfo[$fk]['fvalue'] = $dv[$fid];
                }
                $data[$dk]['data_info'] = $dataInfo;
            }
            $back[0]['datas'] = $data;
//            dd($back);
            return $back;
        }
        return null;
    }


}
