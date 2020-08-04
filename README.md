# blogClass
This is a simple PHP class which allows to manage blog posts which can be of a dynamic type. This could be useful to whoever wants to create a blog which could have even 5-6 different kind of posts. This class is written to use a mix between MySQL tables and JSON content.

## Getting Started
With the following instructions you will be able to make this class running on your own blog.

### Prerequisites
First of all, you will have to set up a local webserver with apache and mysql servers on. You could for example install lampp from here: <a href="https://www.apachefriends.org/index.html">LAMPP</a>
```
cd /home/[username]/Downloads
chmod 755 [package name]
sudo ./[package name]
```
Also, you will have to create a new Database within the local webserver (accessible via http://localhost/phpmyadmin/)
```
CREATE DATABASE databasename; 
```
And, of course, you will need to create a table for the posts such like this:
```
CREATE TABLE post(
    post_id INT(n) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    post_content TEXT NOT NULL,
    post_type VARCHAR(m) NOT NULL,
    post_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
```
Into the post_content you will insert JSON data which will contain the real post format. This could be done with samples like this:
```
{
    "post_title" : "title",
    "post_image" : "image_link",
    "post_content" : "the text content of the post",
    "post_category" : "some plus category",
    .
    .
    .
 }
```
In the same blog you may have, in different pages, different type of posts. Someone could have maybe multiple images, links, descriptions, contents, videos and so on. To handle these different post, normally you would have to create such tables for each kind of post. This can be extremely difficult if the number of post types is big, or even if that number could change over time. This is a way to trick this kind of problem.

### Installation and usage

To install the class you will simply have, first of all, clone this repo in your specified directory:
```
git clone https://github.com/Taster98/blogClass.git
```
Then, you will have to edit the file 'DBClass' with your credentials: (this step could be replaced by creating a own class with db conenction data).
```
<?php
//Class for Database connection
class DbClass{
    protected $conn = null;
    public function openConn(){
        $this->conn = new mysqli("localhost","username","password","databasename");
        return $this->conn;
    }
    public function closeConn(){
        $this->conn->close();
    }
}
?>
```

Then, you will simply have to import the php class Post.php into your project with something like:
```
include("/your/path/Post.php");
```
You then need to edit the body of 'getRightPost' function in order to be able to handle your specific post typologies.
You can find a very simple implementation inside the 'Post.php' class and a post example inside 'Example.php'

### WARNING: You first need to create the database in order to see the example working

## Functions of the class:
- ``` insertPost($json, $type) ``` --> This function is used to insert a new post of a specific category inside your database 
- ``` updatePost($post_id,$json,$type) ``` --> This function is used to update post of a specific category and a specific id inside your database 
- ```  deletePost($post_id) ``` --> This function is used to delete a post of a specific id from your database 
- ```  getPost($post_id) ``` --> This function is used to get a single specific post by post_id 
- ```  getAllPosts() ``` --> This function is used to get all posts in the db 
- ```  getAllPostsSpecific($type,$order) ``` --> This function is used to fetch all posts of a specific Type and in a specific Order (desc for descending order, asc for ascending order)
- ```  getRightPost($post) ``` --> This function must be implemented adapting it to your posts categories in order to make the entire class properly work

## LICENSE
This software is completely free; see <a href="LICENSE">GNU General Public License.</a>