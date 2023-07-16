<?php
namespace App\Controllers;

use App\Models\user;
use App\services\Session;
use App\services\PostGlobal;
use App\db\DatabaseConnection;
require_once 'app/helpers/csrf.php';

/**
 * Register class
 * Register a new user after checking
 */
class Register
{

/**
 * Method to do the checks and to secure the entrances
 * and to add a new user.
 *
 * @return void
 */


public function execute()
{
if (!empty(PostGlobal::getAllPostVars())) {
    if (!validateCsrfToken(PostGlobal::get('csrf_token'))) {
        die("Erreur : Jeton CSRF invalide.");
    }else{
        if (PostGlobal::isParamSet('username') && PostGlobal::isParamSet('password')
            && !empty(PostGlobal::get('username')) && !empty(PostGlobal::get('password'))
        ) {
            $username = strip_tags(trim(PostGlobal::get('username')));
            if (strlen($username) <5) {
                throw new \Exception('pseudo trop court!');
            }

            if (!filter_var(PostGlobal::get('email'), FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('adresse mail incorrecte !');
            }
            $email = PostGlobal::get('email');

            // We check that the nickname is unique.
            $usernameCheck = new User();
            $usernameCheck->connection = new DatabaseConnection();
            $result1 = $usernameCheck->checkUserUsername($username);
            if ($result1) {
                throw new \Exception('pseudo déjà existant !');
            }
            // We check that the email is unique.
            $userMailCheck = new User();
            $userMailCheck->connection = new DatabaseConnection();
            $result2 = $userMailCheck->checkUserEmail($email);
            if ($result2) {
                throw new \Exception('email déjà existant !');
            }

            if (strlen(PostGlobal::get('password')) <= 8) {
                throw new \Exception('Le mot de passe trop court!');
            }
            $passtest = PostGlobal::get('password');

            if (!preg_match("#[0-9]+#", $passtest)) {
                throw new \Exception('Le mot de passe doit contenir au moins 1 chiffre!');
            }

            if (!preg_match("#[A-Z]+#", $passtest)) {
                throw new \Exception('Le mot de passe doit contenir au moins 1 majuscule!');
            }

            if (!preg_match("#[a-z]+#", $passtest)) {
                throw new \Exception('Le mot de passe doit contenir au moins 1 minuscule!');
            }
            $pass = password_hash(PostGlobal::get('password'), PASSWORD_DEFAULT);

            // We add the new user.
            $userRepository = new User();
            $userRepository->connection = new DatabaseConnection();
            $success = $userRepository->addUser($username, $pass, $email);
            if (!$success) {
                throw new \Exception('Impossible d\'ajouter l\'utilisateur !');
            }else{
                $usersession = new User();
                $usersession->connection = new DatabaseConnection();
                $sessionResult = $usersession->checkUserUsername($username);
                Session::put('user_id', $sessionResult->getUser_id());
                Session::put('username', $sessionResult->getUsername());
                Session::put('role', $sessionResult->getRole());

                ?>
                <script>
                alert("Félicitations, vous êtes bien enregistré");
                history.go(-2);
                </script>
                <?php
                
            }
        } else {
            ?>
            <script language="javascript"> 
            alert("Toutes les informations doivent être complétées");
            document.location.href = 'index.php?action=register';</script>
            <?php
        }
    }
}
include 'app/views/register.php';
}


}
