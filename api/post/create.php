<?php
//headers
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods:POST');
require_once "../../config/Database.php";
require_once "../../models/Post.php";
//db connect
$database = new Database;
$db = $database->connect();
//inst post
$post = new Post($db);
// get post request 
$data = json_decode(file_get_contents('php://input'));
$post->title = $data->title;
$post->body =$data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;
if($post->create()){
    echo json_encode(array('message'=>'success'));
}else{
    echo json_encode(array('message'=>'fail'));
}