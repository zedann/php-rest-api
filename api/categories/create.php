<?php
//headers
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods:POST');
require_once "../../config/Database.php";
require_once "../../models/Category.php";
//connect database
$database = new Database();
$db = $database->connect();

$cate = new Category($db);
$data = json_decode(file_get_contents('php://input'));
$cate->name = $data->name;
if($cate->create()){
    echo json_encode(array('message'=>'category created'));
}else{
    echo json_encode(array('message'=>'category faild'));
}

