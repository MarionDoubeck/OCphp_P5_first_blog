<?php
namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\services\Session;
use App\db\DatabaseConnection;
use App\services\Helpers;
use App\services\PostGlobal;

/**
 * DeletePost class
 * To delete post in the admin part
 */
class DeletePost
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
     *
     * @return void
     */
    public function __construct(Session $session, PostGlobal $postGlobal)
    {
        $this->session = $session;
        $this->postGlobal = $postGlobal;

    }//end __construct()


    /**
     * Method to delete a post
     *
     * @param int $identifier post id
     *
     * @return void
     */
    public function execute(string $identifier)
    {
        $helper = new Helpers;
        if ($helper->validateCsrfToken($this->postGlobal->get('csrf_token')) === FALSE) {
            throw new \Exception("Erreur : Jeton CSRF invalide.");
        } else {
            $role = $this->session->get('role');
            if ($role !== 'admin') {
                header("Location: index.php/?action=AccesNonAutorisé");
            }

            $commentRepository = new Comment();
            $commentRepository->connection = new DatabaseConnection();
            $commentsSuccess = $commentRepository->deleteAllComments($identifier);
            if ($commentsSuccess === FALSE) {
                throw new \Exception('Impossible de supprimer les commentaires de l\'article !');
            } else {
                $postRepository = new Post();
                $postRepository->connection = new DatabaseConnection();

                $success = $postRepository->deletePost($identifier);
                if ($success === FALSE) {
                    throw new \Exception('Impossible de supprimer l\'article !');
                } else {
                    ?>
                    <script language="javascript"> 
                    alert("article supprimé");
                    document.location.href = '/index.php?action=adminAllPosts';
                    </script>
                    <?php
                }//end if
            }//end if
        }//end if

    }//end execute()


}//end class
