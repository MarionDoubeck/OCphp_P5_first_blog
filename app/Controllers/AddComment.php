<?php
namespace App\Controllers;

use App\Models\Comment;
use App\services\Session;
use App\db\DatabaseConnection;
use App\services\PostGlobal;
use App\helpers\Helpers;

/**
 * AddComment class
 * To add a new comment after checking
 */
class AddComment
{
    /**
     * Function in charge of doing security checks and adding a new comment
     *
     * @param string $post
     *
     * @return void
     */
    public function execute(string $post)
    {
        $user_id = Session::get('user_id');
        $commentContent = null;

        $helper = new Helpers;
        // We do the checks.
        if (empty(PostGlobal::get('commentContent')) === false) {
            try {
                /* Check if the CSRF token is valid */
                if ($helper->validateCsrfToken(PostGlobal::get('csrf_token')) === FALSE) {
                    throw new \Exception("Erreur : Jeton CSRF invalide.");
                } else{
                    $commentContent = strip_tags(PostGlobal::get('commentContent'));
                }
            } catch (Exception $e) {
                echo "une erreur s'est produite : ". $e->getMessage();
            }
        } else {
            ?>
            <script language="javascript"> 
            var numpost = <?= $post?>;
            alert("les données du commentaires sont invalides");
            document.location.href = 'index.php?action=article&id='+numpost;</script>
            <?php
        }

        // We create a new comment.
        $commentRepository = new Comment();
        $commentRepository->connection = new DatabaseConnection();
        $success = $commentRepository->createComment($post, $user_id, $commentContent);
        if ($success === FALSE) {
            throw new \Exception('Impossible d\'ajouter le commentaire !');
        } else {
            ?>
            <script language="javascript"> 
            var numpost = <?= $post?>;
            alert("Commentaire envoyé, celui-ci sera visible après validation.");
            document.location.href = 'index.php?action=article&id='+numpost;</script>
            <?php
        }
    }


}
