<?php
class Post 
{
    //DB stuff
    protected $table = 'posts';
    protected $conn;

    //Post Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    //Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //get post
    public function read()
    {
        //craete query
        $query = "SELECT
                c.name as category_name,
                p.id,p.category_id,p.title,p.body,p.author,p.created_at
                FROM 
                $this->table p
                LEFT JOIN categories c
                ON c.id = p.category_id
                ORDER BY p.created_at DESC
                 ";
        $stmt =  $this->conn->prepare($query);
        //execute
        $stmt->execute();  

        return $stmt;      
    }
    //get single post
    public function read_single(){
        $query = "SELECT
                c.name as category_name,
                p.id,p.category_id,p.title,p.body,p.author,p.created_at
                FROM 
                $this->table p
                LEFT JOIN categories c
                ON c.id = p.category_id
                WHERE p.id = :id 
                LIMIT 0,1
                ";
         $stmt =  $this->conn->prepare($query);
         //BIND ID
         $stmt->bindParam('id',$this->id);
         //execute
         $stmt->execute(); 
         
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
         //set properties
         $this->title = $row['title'];
         $this->body = $row['body'];
         $this->author = $row['author'];
         $this->category_id = $row['category_id'];
         $this->category_name = $row['category_name'];
    }
    //create post
    public function create()
    {
        $query = "INSERT INTO $this->table (title,body,author,category_id)
        VALUES (:title,:body,:author,:category_id) ";
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->title = htmlspecialchars($this->title);
        $this->body = htmlspecialchars($this->body);
        $this->author = htmlspecialchars($this->author);
        $this->category_id = htmlspecialchars($this->category_id);
        //bind data
        $stmt->bindParam('title',$this->title);
        $stmt->bindParam('body',$this->body);
        $stmt->bindParam('author',$this->author);
        $stmt->bindParam('category_id',$this->category_id);
        //execute
        if($stmt->execute())
        {
            return true;
        }
        //print error 
        printf("error : %s \n",$stmt->error);
        return false;
        
    }
    public function delete(){
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('id',$this->id);
        if($stmt->execute())
        {
            return true;
        }
        //print error 
        printf("error : %s \n",$stmt->error);
        return false;
    }
    public function update()
    {
        $query = "UPDATE $this->table 
                    SET title=:title,body=:body,author=:author,category_id=:category_id
                        WHERE id=:id
        ";
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //bind data
        $stmt->bindParam('title',$this->title);
        $stmt->bindParam('body',$this->body);
        $stmt->bindParam('author',$this->author);
        $stmt->bindParam('category_id',$this->category_id);
        $stmt->bindParam('id',$this->id);
        //execute
        if($stmt->execute())
        {
            return true;
        }
        //print error 
        printf("error : %s \n",$stmt->error);
        return false;
        
    }
}