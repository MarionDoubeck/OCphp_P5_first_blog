<?php
namespace App\models;
use Config\DBConnect;

class User {
    private $first_name;
    private $last_name;
    private $email;
    private $username;
    private $password;
    private $role;
    private $id;

    // Getters and setters for the user properties

    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function setFirstName($first_name) {
        $this->first_name = htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8');
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function setLastName($last_name) {
        $this->last_name = htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8');
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = strtolower($email);
        } else {
            echo "<script>alert('Adresse e-mail non valide');</script>";
        }
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    // Method to check if the user credentials are valid
    public function isCredentialsValid($username, $password) {
        $pdo = DBConnect::getInstance();

        // Prepare the SQL query to check the credentials
        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':username', $username);
        $statement->execute();

        // Fetch the user record
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($user && password_verify(trim($password), trim($user['password']))) {
            return true; // Credentials are valid
        } else {
            return false; // Credentials are invalid
        }
    }

    // Method to check if a user is an admin
    public function isAdmin($username) {
        $pdo = DBConnect::getInstance();

        // Prepare the SQL query to fetch the user role
        $query = "SELECT role FROM users WHERE username = :username";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':username', $username);
        $statement->execute();

        // Fetch the user role
        $userRole = $statement->fetchColumn();

        // Check if the user is an admin based on the role
        // Modify this condition based on your database structure and logic
        if ($userRole === 'admin') {
            return true; // User is an admin
        }

        return false; // User is not an admin or not found
    }

    // Method to get the username by ID
    public static function getUsernameByUserId($id) {
        $pdo = DBConnect::getInstance();

        // Prepare the SQL query to fetch the username by ID
        $query = "SELECT username FROM users WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();

        // Fetch the username
        $username = $statement->fetchColumn();

        return $username;
    }

    //get user's id from username
    public static function getIdFromUsername($username) {
        $pdo = DBConnect::getInstance();
    
        // Prepare the SQL query to fetch the user ID by username
        $query = "SELECT id FROM users WHERE username = :username";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':username', $username);
        $statement->execute();
    
        // Fetch the user ID
        $userId = $statement->fetchColumn();
    
        return $userId;
    }
}
