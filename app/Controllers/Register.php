<?php
namespace App\Controllers;

use App\models\User;
use App\services\Session;
use App\services\PostGlobal;
use App\db\DatabaseConnection;
use App\services\Helpers;

/**
 * Register class
 * Register a new user after checking
 */
class Register
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
     * Constructor that inject dependencies to avoid static access to classes like $this->postGlobal->get()
     *
     * @param Session    $session    Session
     * @param PostGlobal $postGlobal PostGlobal
     *
     * @return void
     */
    public function __construct(Session $session, PostGlobal $postGlobal)
    {
        $this->session = $session;
        $this->postGlobal = $postGlobal;

    }//end __construct()


    /**
     * Method to add a new user.
     *
     * @return void
     */
    public function execute()
    {
        $helper = new Helpers;
        $errors = [];

        if (empty($this->postGlobal->getAllPostVars()) === FALSE) {
            if ($helper->validateCsrfToken($this->postGlobal->get('csrf_token')) === FALSE) {
                $errors[] = "Erreur : Jeton CSRF invalide.";
            } else {
                if ($this->postGlobal->isParamSet('username') === TRUE && $this->postGlobal->isParamSet('password') === TRUE && empty($this->postGlobal->get('username')) === FALSE && empty($this->postGlobal->get('password')) === FALSE) {
                    // Check form entries.
                    $formErrors = $this->checkIfFormIsCorrect();
                    if (empty($formErrors) === TRUE) {
                        $username = strip_tags(trim($this->postGlobal->get('username')));
                        $email = $this->postGlobal->get('email');

                        // We hash password for security issues.
                        $passtest = $this->postGlobal->get('password');
                        $pass = password_hash($this->postGlobal->get('password'), PASSWORD_DEFAULT);

                        // We add the new user.
                        $userRepository = new User();
                        $userRepository->connection = new DatabaseConnection();
                        $success = $userRepository->addUser($username, $pass, $email);
                        if ($success === FALSE) {
                            $errors[] = 'Impossible d\'ajouter l\'utilisateur !';
                        } else {
                            $usersession = new User();
                            $usersession->connection = new DatabaseConnection();
                            $sessionResult = $usersession->checkUserUsername($username);
                            $this->session->put('user_id', $sessionResult->getUser_id());
                            $this->session->put('username', $sessionResult->getUsername());
                            $this->session->put('role', $sessionResult->getRole());

                            ?>
                            <script>
                                alert("Félicitations, vous êtes bien enregistré");
                                window.location.href = '/';
                            </script>
                            <?php
                            return;
                        }// end if
                    }// end if
                } else {
                    $errors[] = "Toutes les informations doivent être complétées";
                }// end if
            }// end if
        }// end if

        $data = [
            'errors' => $errors,
        ];
        $helper->renderView('app/views/register.php', $data);

    }//end execute()


    /**
     * Method to do the checks and to secure the entrances
     *
     * @return void
     */
    public function checkIfFormIsCorrect()
    {
        $errors = [];

        if (strlen(strip_tags(trim($this->postGlobal->get('username')))) < 4) {
            $errors[] = 'Nom d\'utilisateur trop court, il doit faire au moins 4 caractères';
        }

        if (filter_var($this->postGlobal->get('email'), FILTER_VALIDATE_EMAIL) === FALSE) {
            $errors[] = 'Adresse mail incorrecte';
        }

        if (strlen($this->postGlobal->get('password')) <= 8) {
            $errors[] = 'Le mot de passe trop court, il doit faire au moins 8 caractères';
        }

        if (preg_match("#[0-9]+#", $this->postGlobal->get('password')) === 0) {
            $errors[] = 'Le mot de passe doit contenir au moins 1 chiffre';
        }

        if (preg_match("#[A-Z]+#", $this->postGlobal->get('password')) === 0) {
            $errors[] = 'Le mot de passe doit contenir au moins 1 majuscule';
        }

        if (preg_match("#[a-z]+#", $this->postGlobal->get('password')) === 0) {
            $errors[] = 'Le mot de passe doit contenir au moins 1 minuscule';
        }

        $moreErrors = $this->checkIfAlreadyInDb($errors);
        return $moreErrors;

    }//end checkIfFormIsCorrect()


    /**
     * Method to do the checks and to secure the entrances
     *
     * @param array $errors Errors
     *
     * @return array $errors Errors
     */
    public function checkIfAlreadyInDb($errors)
    {
        // We check that the nickname is unique.
        $usernameCheck = new User();
        $usernameCheck->connection = new DatabaseConnection();
        $result1 = $usernameCheck->checkUserUsername(strip_tags(trim($this->postGlobal->get('username'))));
        if ($result1 !== null) {
            $errors[] = 'Nom d\'utilisateur déjà existant';
        }

        // We check that the email is unique.
        $userMailCheck = new User();
        $userMailCheck->connection = new DatabaseConnection();
        $result2 = $userMailCheck->checkUserEmail($this->postGlobal->get('email'));
        if ($result2 !== null) {
            $errors[] = 'Email déjà existant';
        }

        if (empty($errors) === FALSE) {
            $data = [
                'errors' => $errors,
            ];
            $helper = new Helpers;
            $helper->renderView('app/views/register.php', $data);
        }

        return $errors;

    }//end checkIfAlreadyInDb()


}//end class