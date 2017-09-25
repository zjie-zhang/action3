<?php

namespace App\Http\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class dataCenterModel extends Model
{
    protected $collection = 'data_center';

    //
    public function gets()
    {
        $res = DB::collection($this->collection)->where('title','=','email')->limit(2)->get();
        return $res;
    }

    //
    public function add()
    {
        $res = DB::collection('data_center')->insert(['title' => 'email', 'article' => 'zj@example.com','time' => time()]);
        return $res;
    }

    //
    public function up()
    {
        $res = DB::collection('data_center')->where('_id','=','59b8e502fa69eb63e90dfe63')->update(['article'=>'zj@mellete.com']);
        return $res;
    }



}
