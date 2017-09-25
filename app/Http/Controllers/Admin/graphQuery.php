<?php
namespace App\Http\Controllers\Admin;

use GraphQL as Graph;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\User;
use Illuminate\Support\Facades\DB;

class graphQuery extends Query {

    protected $attributes = [
        'name' => 'users'
    ];

    public function type()
    {
        return Type::listOf(Graph::type('test'));
    }

    public function args()
    {

        return [
            'id' => ['name' => 'id', 'type' => Type::string()],
            'email' => ['name' => 'email', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args)
    {
//        var_dump($args);die;

        if(isset($args['id']))
        {
//            return User::where('id' , $args['id'])->get();
            return 123;
        }
        else if(isset($args['email']))
        {
//            return User::where('email', $args['email'])->get();
            return 'aa@qq.com';
        }
        else
        {
//            return User::all();


//            DB::enableQueryLog();
            $res = DB::collection('user')->select('email', '_id')->limit(2)->get()->toArray();
//            dd(DB::getQueryLog());

            foreach ($res as $k => $v) {
                $data[$k]['id'] = (string)$v['_id'];
                $data[$k]['email'] = (string)$v['email'];
            }
            return $data;
        }
    }

}