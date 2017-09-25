<?php

namespace App\Http\Controllers\Admin;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;


class heroQL extends GraphQLType
{

    /*
       * Uncomment following line to make the type input object.
       * http://graphql.org/learn/schema/#input-types
       */
    // protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the user'
            ]
        ];
    }


    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveEmailField($root, $args)
    {
//        dd($root);
        return strtolower($root['name']);
    }

}
