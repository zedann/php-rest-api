<?php
//headers
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
require_once "../../config/Database.php";
require_once "../../models/Post.php";

//db connect
$database = new Database;
$db = $database->connect();
//inst post
$post = new Post($db);
//get id from url
$post->id = isset($_GET['id']) ? $_GET['id'] : die();
//get post 
$post->read_single();
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name,
);

//make json
print_r(json_encode($post_arr));
