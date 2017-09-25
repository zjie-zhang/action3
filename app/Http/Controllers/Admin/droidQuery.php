<?php
namespace App\Http\Controllers\Admin;

use GraphQL as Graph;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\User;
use Illuminate\Support\Facades\DB;

class droidQuery extends Query {

    public function type()
    {
        return Type::listOf(Graph::type('droid'));
//        return Graph::type('droid');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::string())],
//            'name' => ['name' => 'name', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
//        dd($args['id']);
//            DB::enableQueryLog();
        $res = DB::collection('user')->select('name')->where('name','hah')->get()->toArray();
//            dd(DB::getQueryLog());

//            foreach ($res as $k => $v) {
//                $data[$k]['id'] = (string)$v['_id'];
//                $data[$k]['email'] = (string)$v['email'];
//            }
//        dd($res);
        return $res;
    }

}