<?php
namespace App\views;
use Config\DBConnect;

class Home{
    //Methode to get a user by its Id
    public static function getUserById($userId) {
        $pdo = DBConnect::getInstance();
    
        // Prepare the SQL query
        $query = "SELECT * FROM users WHERE id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId);
    
        // Execute the query
        $stmt->execute();
    
        // Fetch the user as an associative array
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        echo 'hello';
        return $user;
    }
}
