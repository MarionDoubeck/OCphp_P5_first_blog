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

    /**
     * Session
     *
     * @var Session
     */
    private $session;

    /**
     * PostGlobal
     *
     * @var PostGlobal
     */
    private $postGlobal;


    /**
     * Constructor that inject dependencies to avoid static access to classes like PostGlobal::get()
     *
     * @param Session    $session    Session
     * @param PostGlobal $postGlobal PostGlobal
     * @param Server     $server     Server
     *
     * @return void
     */
    public function __construct(Session $session, PostGlobal $postGlobal, Server $server)
    {
        $this->session = $session;
        $this->postGlobal = $postGlobal;
        $this->server = $server;

    }//end __construct()


    /**
     * Method which verifies the username and password of the user
     * and retrieves the session data
     *
     * @return void
     */
    public function execute()
    {
        $helper = new Helpers;
        if ($this->server->requestMethod() === 'POST') {
            if ($helper->validateCsrfToken($this->postGlobal->get('csrf_token')) === FALSE) {
                throw new \Exception("Erreur : Jeton CSRF invalide.");
            } else {
                $username = null;
                if ($this->postGlobal->isParamSet('username') === TRUE &&  $this->postGlobal->isParamSet('password') === TRUE
                    && empty(trim($this->postGlobal->get('username'))) === FALSE && empty($this->postGlobal->get('password')) === FALSE
                ) {
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
                        if (password_verify(trim($this->postGlobal->get('password')),$connectedUser->getPassword()) === TRUE) {
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
                    }//'endif'
                } else {?>
                    <script language="javascript"> 
                    alert("Vous devez remplir tous les champs");
                    </script>
                    <?php
                }

            }
        }
        $helper->renderView('app/views/login.php',[]);

    }//end execute()


}//end class
