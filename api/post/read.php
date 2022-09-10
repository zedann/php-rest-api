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
//blog post query
$result = $post->read();
// get row count
$num = $result->rowCount();
//check if any post
if($num > 0){
    $posts_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $post_item = array(
            'id'=>$id,
            'title'=>$title,
            'body'=>html_entity_decode($body),
            'author'=>$author,
            'category_id'=>$category_id,
            'category_name'=>$category_name, 
        );
        //push to data
        array_push($posts_arr,$post_item);
    }
    //turn to json and output
    echo json_encode($posts_arr);
}else{
    //no posts
    echo json_encode(
        array('message'=>'No Post Found')
    );
}

