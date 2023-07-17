<?php
namespace App\Controllers;

use App\Models\Comment;
use App\services\Session;
use App\db\DatabaseConnection;

/**
 * DeleteComment class
 * To delete comment in the admin part
 */
class DeleteComment
{
    /**
     * Method to delete a comment
     *
     * @param int $identifier
     *
     * @return void
     */


    public function execute(int $identifier)
    {
        $role = Session::get('role');
        if ($role !== 'admin') {
            throw new \Exception('Page résevée à l\'administration !');
        }
        $postRepository = new Comment();
        $postRepository->connection = new DatabaseConnection();
        $success = $postRepository->deleteComment($identifier);
        if ($success === FALSE) {
            throw new \Exception('Impossible de supprimer le commentaire !');
        } else {
            ?>
            <script language="javascript"> 
            alert("Commentaire supprimé");
            document.location.href = '/index.php?action=adminPendingComments';</script>
            <?php
        }
    }


}
