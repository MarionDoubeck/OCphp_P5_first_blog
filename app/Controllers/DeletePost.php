<?php
namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\services\Session;
use App\db\DatabaseConnection;
use App\helpers\Helpers;
use App\services\PostGlobal;

/**
 * DeletePost class
 * To delete post in the admin part
 */
class DeletePost
{
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
        if ($helper->validateCsrfToken(PostGlobal::get('csrf_token')) === FALSE) {
            throw new \Exception("Erreur : Jeton CSRF invalide.");
        } else {
            $role = Session::get('role');
            if ($role !== 'admin') {
                throw new \Exception('Page résevée à l\'administration !');
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
                    document.location.href = 'index.php?action=adminAllPosts';
                    </script>
                    <?php
                }
            }
        }
    }
}