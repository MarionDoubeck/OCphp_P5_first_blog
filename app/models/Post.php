<?php
namespace App\models;
use Config\DBConnect;

class Post {
    public $id;
    public $title;
    public $content;

    //get a post in the database from its ID
    public static function getById($postId) {
        $pdo = DBConnect::getInstance();
    
        // Prepare the SQL query
        $query = "SELECT * FROM posts WHERE id = :postId";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':postId', $postId);
        $statement->execute();
    
        // Fetch the post record
        $post = $statement->fetch(PDO::FETCH_ASSOC);
    
        return $post;
    }

}
