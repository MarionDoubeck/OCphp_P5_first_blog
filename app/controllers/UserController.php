<?php
namespace App\controllers;

if (!isset($_SESSION)) {
    session_start();
}

use Config\DBConnect;
use App\models\User;
require_once __DIR__ .'/../helpers/csrf.php';

class UserController {
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
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $user;
    }
    // Method to get the username by user ID
    public static function getUsernameByUserId($userId) {
        // Retrieve the user from the model based on the ID
        $user = self::getUserById($userId);

        // Return the username
        return $user['username'];
    }
    // Method to register a new user
    public function register() {
        // Process the registration form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the registration data from the form
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Create a new user object
            $user = new User();

            // Set the user properties
            $user->setFirstName($first_name);
            $user->setLastName($last_name);
            $user->setEmail($email);
            $user->setUsername($username);
            $user->setRole("user");

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user->setPassword($hashedPassword);

            // Save the user in the database
            $user->save();

            // Display an alert message for validation
            $_SESSION['registration_message'] = "Félicitations, vous êtes enregistré";

            // Redirect to login page
            header("Location: /app/views/login.php");
            exit;
        }
    }

    // Method to log in a user
    public function login() {
        // Process the login form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the CSRF token is valid
            if (!validateCsrfToken($_POST['csrf_token'])) {
                die("Erreur : Jeton CSRF invalide.");
            }
            // Retrieve the login data from the form
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Create a new user object
            $user = new User();

            // Check if the user credentials are valid
            if ($user->isCredentialsValid($username, $password)) {
                // Set the user session
                $_SESSION['user_username'] = $username;
                $_SESSION['user_isAdmin'] = $user->isAdmin($username);

                $_SESSION['user_id'] = $user->getIdFromUsername($username);

                // Redirect to previous page
                ?>
                <script>
                    history.go(-2);
                </script>
                <?php
                exit;
            } else {
                // Display an alert message for incorrect credentials
                echo "<script>alert('Mauvais nom d\\'utilisateur ou mot de passe');</script>";
            }
        }
    }

}