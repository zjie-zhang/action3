<?php
namespace App\Http\Controllers\Admin;

use GraphQL as Graph;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\User;

use Illuminate\Support\Facades\DB;


class updateDroidMutation extends Mutation {

    protected $attributes = [
        'name' => 'updateDroid'
    ];

    public function type()
    {
        return Type::listOf(Graph::type('droid'));
//        return Graph::type('droid');
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::string())
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string()
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $user = DB::collection('user')->where('_id',$args['id'])->get();
        if(!$user)
        {
            return null;
        }

        if(DB::collection('user')->where('_id',$args['id'])->update(['name'=>$args['name']])) {
            $data[0] = array(
                'id' => $args['id'],
                'name' => $args['name']
            );
            return $data;
        }
        return null;
    }

}