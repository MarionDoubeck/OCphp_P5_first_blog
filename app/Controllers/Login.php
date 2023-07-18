<?php
namespace App\Controllers;

use App\Models\User;
use App\services\Session;
use App\services\PostGlobal;
use App\services\Server;
use App\db\DatabaseConnection;
use App\services\Helpers;

/**
 * Class login
 * To login the user
 */
class Login
{
    private $session;
    private $postGlobal;


    /**
     * Constructor that inject dependencies to avoid static access to classes like PostGlobal::get()
     * 
     * @return void
     */
    public function __construct(Session $session, PostGlobal $postGlobal)
    {
        $this->session = $session;
        $this->postGlobal = $postGlobal;
    }

    /**
     * Method which verifies the username and password of the user
     * and retrieves the session data
     *
     * @return void
     */
    public function execute()
    {
        $helper = new Helpers;
        if (Server::requestMethod() === 'POST') {
            if ($helper->validateCsrfToken($this->postGlobal->get('csrf_token')) === FALSE) {
                throw new \Exception("Erreur : Jeton CSRF invalide.");
            } else{
                $username = null;
                if ($this->postGlobal->isParamSet('username') === TRUE &&  $this->postGlobal->isParamSet('password') === TRUE
                    && empty(trim($this->postGlobal->get('username'))) === FALSE && empty($this->postGlobal->get('password')) === FALSE ) {
                    $username = htmlspecialchars(trim($this->postGlobal->get('username')));
                    $userRepository = new User();
                    $userRepository->connection = new DatabaseConnection();
                    $connectedUser = $userRepository->checkUserUsername($username);
                    if ($connectedUser === null) {
                        ?>
                        <script language="javascript"> 
                        alert("Mauvais nom d'utilisateur");
                        window.location.reload();
                        </script>
                        <?php
                    } else {
                        if (password_verify(
                            trim($this->postGlobal->get('password')),
                            $connectedUser->getPassword()
                        )
                        ) {
                            $this->session->put('user_id', $connectedUser->getUser_id());
                            $this->session->put('username', $connectedUser->getUsername());
                            $this->session->put('role', $connectedUser->getRole());

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
        $helper->renderView('app/views/login.php',[]);
    }
}
 