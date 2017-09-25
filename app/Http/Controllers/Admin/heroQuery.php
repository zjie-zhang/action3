<?php
namespace App\Http\Controllers\Admin;

use GraphQL as Graph;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\User;
use Illuminate\Support\Facades\DB;

class heroQuery extends Query {


    public function type()
    {
        return Type::listOf(Graph::type('hero'));
    }

    public function args()
    {

        return [
            'name' => ['name' => 'name', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
//            DB::enableQueryLog();
            $res = DB::collection('user')->select('name')->where('name','hehe')->get()->toArray();
//            dd(DB::getQueryLog());

//            foreach ($res as $k => $v) {
//                $data[$k]['id'] = (string)$v['_id'];
//                $data[$k]['email'] = (string)$v['email'];
//            }
//        dd($res);
            return $res;
    }

}