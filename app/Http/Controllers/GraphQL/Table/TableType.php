<?php

namespace App\Http\Controllers\GraphQL\Table;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;


class TableType extends GraphQLType
{
    protected $attributes = [
        'name' => 'table',
        'description' => 'dataCenterDefine'
    ];

    public $typeName='';
    /*
     * Uncomment following line to make the type input object.
     * http://graphql.org/learn/schema/#input-types
     */
//     protected $inputObject = true;

//    public function __construct($typeName = 'table')
//    {
//        $this->typeName = $typeName;
//    }


    public function fields()
    {
//        echo 111;

        $fieldsInfo = new ObjectType([
            'name' => 'fieldsInfo',
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
            ]
        ]);

        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'The id of the table'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of table'
            ],
            'row_num' => [
                'type' => Type::int(),
            ],
            'column_num' => [
                'type' => Type::int(),
            ],
            'create_time' => [
                'type' => Type::int(),
            ],
            'update_time' => [
                'type' => Type::int(),
            ],
            'msg' => [
                'type' => Type::string(),
            ],
            'info' => [
                'type' => Type::string(),
            ],
            'errcode' => [
                'type' => Type::int(),
            ],
            'errmsg' => [
                'type' => Type::string(),
            ],
            'fields_info' => [
                'type' => Type::listOf($fieldsInfo),
            ]
        ];

//        echo 111;
//        $typename = $this->typeName;
//        dd($typename);
//        dd($this->$typename());
//        return $this->$typename();
    }

    public function createTable()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the table'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of table'
            ],
            'row_num' => [
                'type' => Type::int(),
            ],
            'column_num' => [
                'type' => Type::int(),
            ],
            'create_time' => [
                'type' => Type::int(),
            ],
            'update_time' => [
                'type' => Type::int(),
            ],
            'msg' => [
                'type' => Type::string(),
            ]
        ];
    }


    public function tables()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the table'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of table'
            ],
            'row_num' => [
                'type' => Type::int(),
            ],
            'column_num' => [
                'type' => Type::int(),
            ],
            'create_time' => [
                'type' => Type::int(),
            ],
            'update_time' => [
                'type' => Type::int(),
            ],
            'msg' => [
                'type' => Type::string(),
            ]
        ];

    }

    public function deleteTable()
    {
        return [
            'errcode' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the table'
            ],
            'errmsg' => [
                'type' => Type::string(),
            ]
        ];
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
//    protected function resolveEmailField($root, $args)
//    {
//        return strtolower($root['name']);
//    }
}



