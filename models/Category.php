<?php

class Category
{
    protected $table = 'categories';
    protected $conn;
    //properties to deal with api
    public $id;
    public $name;
    public $created_at;
    //construct
    public function __construct($db)
    {
        //get connection form db
        $this->conn = $db;
    }
    //read categories
    public function read()
    {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt; 
    }
    public function create()
    {
        $query = "INSERT INTO $this->table 
        (name) VALUES (:name)
        ";
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars($this->name);
        $stmt->bindParam('name',$this->name);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }
    public function update()
    {
        $query = "UPDATE $this->table 
        SET name = :name WHERE id = :id
        ";
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name) );
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':id',$this->id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function delete()
    {
        $query = "DELETE FROM $this->table WHERE id = :id
        ";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id',$this->id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }


}