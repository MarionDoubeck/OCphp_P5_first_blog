<?php
namespace App\Controllers;

use App\Models\User;
use App\services\Session;
use App\services\PostGlobal;
use App\db\DatabaseConnection;
require_once 'app/helpers/csrf.php';

/**
 * Class login
 * To login the user
 */
class Login
{
    /**
     * Method which verifies the username and password of the user
     * and retrieves the session data
     *
     * @return void
     */


    public function execute()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            /* Check if the CSRF token is valid */
            if (!validateCsrfToken($_POST['csrf_token'])) {
                die("Erreur : Jeton CSRF invalide.");
            }else{
                $username = null;
                if (isset($_POST['username']) &&  isset($_POST['password'])
                    && !empty(trim($_POST['username'])) && !empty($_POST['password'])
                ) {
                    $username = htmlspecialchars(trim($_POST['username']));
                
                    $userRepository = new User();
                    $userRepository->connection = new DatabaseConnection();
                    $connectedUser = $userRepository->checkUserUsername($username);
                    if (!$connectedUser) {
                        ?>
                        <script language="javascript"> 
                        alert("Mauvais pseudo");
                        </script>
                        <?php
                    } else {
                        if (password_verify(
                            trim($_POST['password']),
                            $connectedUser->getPassword()
                        )
                        ) {
                            Session::put('user_id', $connectedUser->getUser_id());
                            Session::put('username', $connectedUser->getUsername());
                            Session::put('role', $connectedUser->getRole());

                            ?>
                            <script language="javascript"> 
                            alert("Connexion réussie!");
                            history.go(-2);
                            </script>
                            <?php
                        } else {
                            ?>
                            <script language="javascript"> 
                            alert("Mauvais mot de passe");
                            </script>
                            <?php
                        }
                    }
                } else {?>
                    <script language="javascript"> 
                    alert("Vous devez remplir tous les champs");
                    </script>
                    <?php
                }
            }
        }
        include 'app/views/login.php';
    }


}
 