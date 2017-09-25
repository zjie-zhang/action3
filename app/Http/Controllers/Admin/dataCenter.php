<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Admin\dataCenterModel;
use Illuminate\Http\Request;

class dataCenter extends Controller
{
    //
    public function index()
    {
        $dbModel = new \connectMongo();
        $conn = $dbModel->connMongo();
        $collection = $conn->user; // 选择集合
        $cursor = $collection->find(['name'=>'zj']);
        // 迭代显示文档标题
        foreach ($cursor as $document) {
            var_dump($document);
        }
        dd(1);

        $model = new dataCenterModel();
        $res = $model->gets();
        var_dump($res);
    }


    public function store()
    {
        $model = new dataCenterModel();
        $res = $model->add();
        var_dump($res);
    }


    public function update()
    {
        $model = new dataCenterModel();
        $res = $model->up();
        var_dump($res);
    }
    
    
}
