<?php
namespace App\Controllers;
use App\services\Helpers;
use App\Models\Post;
use App\services\Session;
use App\services\PostGlobal;
use App\services\Files;
use App\services\Server;
use App\db\DatabaseConnection;

/**
 * AdminAddPost class
 * To add a new post in the admin part
 */
class AdminAddPost
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
     * Server
     *
     * @var Server
     */
    private $server;

    /**
     * Files
     *
     * @var Files
     */
    private $files;


    /**
     * Constructor that inject dependencies to avoid static access to classes like PostGlobal::get()
     *
     * @param Session    $session    Session
     * @param PostGlobal $postGlobal PostGlobal
     * @param Server     $server     Server
     * @param Files      $files      Files
     *
     * @return void
     */
    public function __construct(Session $session, PostGlobal $postGlobal, Server $server, Files $files)
    {
        $this->session = $session;
        $this->postGlobal = $postGlobal;
        $this->server = $server;
        $this->files = $files;

    }//end __construct()


    /**
     * Method to add a new post
     *
     * @return void
     */
    public function execute()
    {
        $helper = new Helpers;
        $role = $this->session->get('role');
        $user_id = $this->session->get('user_id');
        $content = null;
        $title = null;
        $chapo = null;

        if ($role !== 'admin') {
            $helper->renderView('app/views/404.php',[]);
        }

        if ($this->server->requestMethod() === 'POST') {
            if ($helper->validateCsrfToken($this->postGlobal->get('csrf_token')) === FALSE) {
                throw new \Exception("Erreur : Jeton CSRF invalide.");
            } else {
                // We do the checks.
                if (empty($this->postGlobal->get('content')) === FALSE && empty($this->postGlobal->get('title')) === FALSE
                    && empty($this->postGlobal->get('chapo')) === FALSE
                    ) {
                    $content = strip_tags($this->postGlobal->get('content'));
                    $title = strip_tags($this->postGlobal->get('title'));
                    $chapo = strip_tags($this->postGlobal->get('chapo'));
                    // Check if an image was uploaded.
                    if (empty($this->files->file('image','tmp_name')) === FALSE) {
                        // Process the uploaded image.
                        $image_data = file_get_contents($this->files->file('image','tmp_name'));
                        $image_type = $this->files->file('image','tmp_name');
                    } else {
                        $image_data = null;
                        $image_type = null;
                    }
                } else {
                    ?>
                    <script language="javascript"> 
                        alert("les données du formulaire sont invalides");
                        document.location.href = '/index.php?action=adminAddPost';
                    </script>
                    <?php
                }//end if

                // We create the new article.
                $postRepository = new Post();
                $postRepository->connection = new DatabaseConnection();
                $success = $postRepository->addPost($title, $content, $chapo, $user_id, $image_data, $image_type);
                if ($success === FALSE) {
                    throw new \Exception('Impossible d\'ajouter l\'article !');
                } else {
                    ?>
                    <script language="javascript"> 
                    alert("article ajouté");
                    document.location.href = '/index.php?action=adminAllPosts';
                    </script>
                    <?php
                }
            }//end if
        }//end if

        $helper->renderView('app/views/admin/add-post.php',[]);

    }//end execute()


}//end class
