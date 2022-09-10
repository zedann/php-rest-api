<?php
//headers
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods:DELETE');
require_once "../../config/Database.php";
require_once "../../models/Category.php";
//connect database
$database = new Database();
$db = $database->connect();

$cate = new Category($db);
$cate->id = isset($_GET['id']) ? $_GET['id'] : die();
if($cate->delete()){
    echo json_encode(array('message'=>'category Deleted'));
}else{
    echo json_encode(array('message'=>'category Deleted faild'));
}

