<?php
//headers
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
require_once "../../config/Database.php";
require_once "../../models/Category.php";
//db connect
$database = new Database;
$db = $database->connect();
//inst post
$cate = new Category($db);
//blog post query
$result = $cate->read();
// get row count
$num = $result->rowCount();
//check if any post
if($num > 0){
    $cate_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $cate_item = array(
            'id'=>$id,
            'name'=>$name,
            'created_ar'=>$created_at
        );
        //push to data
        array_push($cate_arr,$cate_item);
    }
    //turn to json and output
    echo json_encode($cate_arr);
}else{
    //no posts
    echo json_encode(
        array('message'=>'No Post Found')
    );
}

