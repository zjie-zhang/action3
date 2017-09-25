<?php

namespace App\Http\Controllers\GraphQL\Table;

use GraphQL as Graph;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\DB;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use MongoDB\BSON\ObjectID;


class CreateTable extends Mutation
{
    protected $attributes = [
        'name' => 'createTable'
    ];

    public function type()
    {
//        echo 555;
        return Type::listOf(Graph::type('table'));
    }

    public function args()
    {
//        echo 666;
//        $typeModel = new TableType();
//        $typeModel->typeName = $this->attributes['name'];
//        dd($this->attributes['name']);

        $filters = new InputObjectType([
            'name' => 'fieldInput',
            'fields' => [
                'ftype' => [
                    'type' => Type::string(),
                ],
                'fname' => [
                    'type' => Type::string(),
                ]
            ]
        ]);

        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => "appID"
            ],
            'name' => [
                'type' => Type::string(),
                'description' => "tableName"
            ],
            'fields' => [
                'type' => Type::nonNull(Type::listOf($filters)),
                'description' => "the table fields"
            ],
        ];
    }

    public function resolve($root, $args)
    {
//        echo 777;
        $appId = $args['id'];   # appID
        $tableName = $args['name']; # 表名
        $tableFields = $args['fields'];

//        if (DB::collection('action_app')->where('_id',$appId)->count()) { // 验证APPID
            foreach ($tableFields as $k => $v) {
                $tableFieldsNew[$k]['fid'] = new ObjectID();
                $tableFieldsNew[$k]['fname'] = $v['fname'];
                $tableFieldsNew[$k]['ftype'] = $v['ftype'];
            }
            $data['app_id'] = $appId;
            $data['table_name'] = $tableName;
            $data['table_fields'] = $tableFieldsNew;
            $data['create_time'] = time();
            $data['update_time'] = time();
            $data['is_del'] = 0;
//            dd($data);
            try{
                if ($insId = DB::collection('action_table_define')->insertGetId($data)) {

                    $res = DB::collection('action_table_define')->where('_id',$insId)->first();
                    // 处理数据
                    $back[0]['id'] = (string)$res['_id'];
                    $back[0]['name'] = (string)$res['table_name'];
                    $back[0]['row_num'] = 0;
                    $back[0]['column_num'] = count($res['table_fields']);
                    $back[0]['create_time'] = $res['create_time'];
                    $back[0]['update_time'] = $res['update_time'];
//                $back[0]['fields'] = $res['table_fields'];
                    return $back;
                }

            } catch (\Exception $e) {
                $message = $e->getMessage();
                return $message;
            }


//        }
//        return null;

    }





}
