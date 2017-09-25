<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Common\CommonApi;
use Illuminate\Http\Request;

class Data extends CommonApi
{
    private $actionKey = 'Action!@#Api';
    public $errcode = 0;
    public $errmsg = '';
    public $errdata = [];

    // 生成action文件通知接口
    public function actionFile()
    {
        $apiName = 'actionFile';
        $key = $this->actionKey;

        $requestData = $_REQUEST;
        $token = $requestData['token'];
        $unixtime = $requestData['unix_time'];
        $checkToken = md5($apiName . $key . $unixtime);
        $timePass = time() - (int)$unixtime;
        if ($timePass > 60) {
            $this->errcode = -2;
            $this->errmsg = '链接已失效';
        } elseif ($token != $checkToken) {
            $this->errcode = -2;
            $this->errmsg = '链接不正确';
        } else {
            if (isset($requestData)) {

            }
        }
        returnJson($this->errcode,$this->errmsg,$this->errdata);
    }





}
