<?php
/**
 * Created by PhpStorm.
 * User: Mellete
 * Date: 2017-09-19
 * Time: 11:25
 */


/**
 * Class connectMongo
 * 连接Mongodb
 *
 */
class connectMongo{
    private $host;
    private $port;
    private $database;

    public function __construct()
    {
        $this->host = env('DB_HOST', 'localhost');
        $this->port = env('DB_PORT', '27017');
        $this->database = env('DB_DATABASE', 'action');
    }

    public function connMongo()
    {
        $drive = "mongodb://" . $this->host . ":" . $this->port;
        $conn = new MongoClient($drive); // 连接
        $dbName = $this->database;
        $conn = $conn->$dbName;
        return $conn;
    }
}


function returnJson($errcode,$errmsg,$data = []) {
    $returnData = array();
    $returnData['errcode'] = $errcode;
    $returnData['errmsg'] = $errmsg;
    if (!empty($data))
        $returnData['data'] = $data;

    header("Content-Type:text/json");
    echo json_encode($returnData);

}








