<?php
namespace App\Controllers;

use App\Models\Comment;
use App\services\Session;
use App\db\DatabaseConnection;

/**
 * ValidateComment class
 * To validate comment in the admin part
 */
class ValidateComment
{
    /**
     * Method to validate a comment
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
        $success = $postRepository->validateComment($identifier);
        if ($success === FALSE) {
            throw new \Exception('Impossible de valider le commentaire !');
        } else {
            ?>
            <script language="javascript"> 
            alert("Commentaire publié");
            document.location.href = '/index.php?action=adminPendingComments';</script>
            <?php
        }
    }
}