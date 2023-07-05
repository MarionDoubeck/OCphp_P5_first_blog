<?php
namespace App\controllers;

use App\models\Post;

if (!isset($_SESSION)) {
    session_start();
}

class PostController {
    private $pdo;

    public function __construct() {
        $this->pdo = DBConnect::getInstance();
    }

    // Method to get the 3 most recent posts
    public function getRecentPosts() {
        // Query to retrieve the 3 most recent posts by creation date
        $query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 3";
        $statement = $this->pdo->query($query);

        // Fetch the recent posts as associative arrays
        $recentPosts = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $recentPosts;
    }
}