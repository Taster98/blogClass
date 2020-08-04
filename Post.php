<?php
error_reporting(E_ALL & ~E_NOTICE);
include "DBClass.php";

class Post{
    protected $db = null;
    //new db creation
    public function __construct(){
        $this->db = new DbConnection();
    }

    /*Functions to interact with db*/

    //This function let you insert a new post of a specific type into the db, where 'json' will be the JSON content file
    public function insertPost($json, $type){
        $con = $this->db->openConn();
        $r_type = $con->real_escape_string($type);
        //We use mysql prepare statements for a better security
        $query = $con->prepare("INSERT INTO post (post_content,post_type) VALUES (?,?)");
        $query->bind_param("ss",$json,$r_type);
        $result = $query->execute();
        if(!$result){
            $error = $con->error;
            $this->db->closeConn();
            return $error;
        }
        $result = true;
        return $result;
    }
    //This function let you update post of a specific type and id from the db, where 'json' will be the JSON content file
    public function updatePost($post_id,$json,$type){
        $con = $this->db->openConn();
        $r_type = $con->real_escape_string($type);
        $query = $con->prepare("UPDATE post SET post_content = ? , post_type = ? WHERE post_id = ?");
        $query->bind_param("ssi",$json,$r_type,$post_id);
        $result = $query->execute();
        if (!$result) {
            $error = $con->error;
            $this->db->closeConn();
            return $error;
        }
        $result = true;
        return $result;
    }
    //This function let you delete post of a specific post_id from the db
    public function deletePost($post_id){
        $con = $this->db->openConn();
        $sql = "DELETE FROM post WHERE post_id = '$post_id'";
        $result = $con->query($sql);
        if(!$result){
            $error = $con->error;
            $this->db->closeConn();
            return $error;
        }
        $result = true;
        return $result;
    }

    //This function let you get a single specific post by post_id
    public function getPost($post_id){
        $con = $this->db->openConn();
        $query = "SELECT * FROM post WHERE post_id = ?";
        $result = $con->prepare($query);
        $result->bind_param("i",$post_id);
        $result->execute();
        $result = $result->get_result();
        $sql = $result->fetch_assoc();
        $this->db->closeConn();
        $res = $this->getRightPost($sql);
        return $res;
    }
    //This function let you get all posts in the db
    public function getAllPosts(){
        $con = $this->db->openConn();
        $selectPosts = "SELECT * FROM post;";
        $result = $con->query($selectPosts);
        if($result->num_rows < 1){
            $sql = "No post";
        }else{
            $sql = $result;
        }
        $this->db->closeConn();
        return $sql;
    }

    //This function let you fetch all posts of a specific Type and in a specific Order (desc for DESC order, asc for ASC order)
    public function getAllPostsSpecific($type,$order){
        $con = $this->db->openConn();
        if($order == "desc")
            $query = "SELECT * FROM post WHERE post_type = ? ORDER BY data DESC;";
        else
            $query = "SELECT * FROM post WHERE post_type = ? ORDER BY data ASC;";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $type);
        $stmt->execute();
        $result = $stmt->get_result();
        $sql = mysqli_fetch_all($result, MYSQLI_ASSOC);            
        $this->db->closeConn();
        return $sql;
    }

    /*** EXAMPLE - YOU NEED TO CHANGE THIS ACCORDING TO YOUR POST TYPES ***/

    //Here it is an example of getting the post in the right format, with a parser for the given json by its type into an array:
    public function getRightPost($post){
        switch($post["post_type"]){
            case "book" :
                $json_array = json_decode($post["json"],true);
                $post_title = $json_array['post_title'];
                $title = $json_array['title'];
                $author = $json_array['author'];
                $language = $json_array['language'];
                $summary = $json_array['summary'];
                $complete_array = array("post_title"=>$post_title,"title"=>$title,"author"=>$author,"language"=>$language,"summary"=>$summary);
                return $complete_array;
            break;
            case "movie" :
                $json_array = json_decode($post["json"],true);
                $post_title = $json_array["post_title"];
                $title = $json_array["title"];
                $summary = $json_array["summary"];
                $array_completo = array("post_title" => $post_title,"title"=>$title, "summary" => $summary);
                return $array_completo;
            break;
        }
    }
}
?>