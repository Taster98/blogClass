<?php
//Class for Database connection
class DbClass{
    protected $conn = null;
    public function openConn(){
        //CHANGE THESE DATA WITH YOURS
        $this->conn = new mysqli("localhost","username","password","databasename");
        return $this->conn;
    }
    public function closeConn(){
        $this->conn->close();
    }
}
?>