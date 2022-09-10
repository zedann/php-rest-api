<?php
//headers
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method:DELETE');
header('Content-Type:application/json');
require_once "../../config/Database.php";
require_once "../../models/Post.php";
//db connect
$database = new Database;
$db = $database->connect();
//inst post
$post = new Post($db);

$post->id = isset($_GET['id']) ? $_GET['id'] : die();

if($post->delete()){
    echo json_encode(array('message'=>'post deleted successfuly'));
}else{
    echo json_encode(array('message'=>'post deleted fail'));
}

    

