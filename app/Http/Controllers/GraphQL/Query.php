<?php

namespace App\Http\Controllers\GraphQL;


use App\Http\Controllers\Common\Common;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Query extends Common {

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
            dd($args);
                        return $root['prefix'] . $args['message'];
                    }
                ],
            ],
        ]);
        $this->query($queryType);
    }


    public function query($queryType)
    {
        $schema = new Schema([
            'query' => $queryType
        ]);
        $rawInput = $_POST;
//        $rawInput = file_get_contents("php://input");
        $input = json_decode($rawInput['a'], true);
        $query = $input['query'];
//        dd($query);
        $variableValues = isset($input['variables']) ? $input['variables'] : null;
        // {"query": "query { echo(message: \"Hello World\") }" }
        try {
            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();
        } catch (\Exception $e) {
            $output = [
                'errors' => [
                    [
                        'message' => $e->getMessage()
                    ]
                ]
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($output);

    }


}