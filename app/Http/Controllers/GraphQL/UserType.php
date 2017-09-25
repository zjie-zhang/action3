<?php

namespace App\GraphQL\Type;

use App\Http\Controllers\Common\commonController;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


class graphQL extends commonController
{

    public function index()
    {
        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => [
                'echo' => [
                    'type' => Type::string(),
                    'args' => [
                        'message' => Type::nonNull(Type::string()),
                    ],
                    'resolve' => function ($root, $args) {
                        return $root['prefix'] . $args['message'];
                    }
                ],
            ],
        ]);

    }

}
