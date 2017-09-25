<?php

namespace App\Http\Controllers\GraphQL\Table;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class DataType extends GraphQLType
{
    protected $attributes = [
        'name' => 'data',
        'description' => 'dataCenterData'
    ];

    public function fields()
    {
        $dataType = new ObjectType([
            'name' => 'dataInfo',
            'fields' => [
                'fid' => [
                    'type' => Type::string(),
                ],
                'fname' => [
                    'type' => Type::string(),
                ],
                'ftype' => [
                    'type' => Type::string(),
                ],
                'fvalue' => [
                    'type' => Type::string(),
                ]
            ]
        ]);

        $datasType = new ObjectType([
            'name' => 'datas',
            'fields' => [
                'data_id' => [
                    'type' => Type::string(),
                ],
                'data_info' => [
                    'type' => Type::listOf($dataType),
                ]
            ]
        ]);

//        $dataFilters = new ObjectType([
//            'name' => 'datas',
//            'fields' => [
//                'fid' => [
//                    'type' => Type::string(),
//                ],
//                'fname' => [
//                    'type' => Type::string(),
//                ],
//                'ftype' => [
//                    'type' => Type::string(),
//                ],
//                'fvalue' => [
//                    'type' => Type::string(),
//                ]
//            ]
//        ]);
        return [
            'id' => [
                'type' => Type::string(),
            ],
            'datas' => [
                'type' => Type::listOf($datasType),
            ],
            'errcode' => [
                'type' => Type::int(),
            ],
            'errmsg' => [
                'type' => Type::string(),
            ]
        ];
    }

}
