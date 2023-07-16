<?php
namespace App\Controllers;

use App\Models\Comment;
use App\services\Session;
use App\db\DatabaseConnection;
use App\services\PostGlobal;
require_once 'app/helpers/csrf.php';

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
        // We do the checks.
        if (!empty(PostGlobal::get('commentContent'))) {
            /* Check if the CSRF token is valid */
            if (!validateCsrfToken($_POST['csrf_token'])) {
                die("Erreur : Jeton CSRF invalide.");
            }else{
                $commentContent = strip_tags(PostGlobal::get('commentContent'));
            }
        } else {
            ?>
            <script language="javascript"> 
            var numpost = <?php echo $post?>;
            alert("les données du commentaires sont invalides");
            document.location.href = 'index.php?action=article&id='+numpost;</script>
            <?php
        }

        // We create a new comment.
        $commentRepository = new Comment();
        $commentRepository->connection = new DatabaseConnection();
        $success = $commentRepository->createComment($post, $user_id, $commentContent);
        if (!$success) {
            throw new \Exception('Impossible d\'ajouter le commentaire !');
        } else {
            ?>
            <script language="javascript"> 
            var numpost = <?php echo $post?>;
            alert("Commentaire envoyé, celui-ci sera visible après validation.");
            document.location.href = 'index.php?action=article&id='+numpost;</script>
            <?php
        }
    }


}
