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
     * Session
     *
     * @var Session
     */
    private $session;


    /**
     * Constructor that inject dependencies to avoid static access to classes like PostGlobal::get()
     *
     * @param Session $session Session
     *
     * @return void
     */
    public function __construct(Session $session)
    {
        $this->session = $session;

    }//end __construct()


    /**
     * Method to validate a comment
     *
     * @param int $identifier CommentId
     *
     * @return void
     */
    public function execute(int $identifier)
    {
        $role = $this->session->get('role');
        if ($role !== 'admin') {?>
            <?= '<script>window.location.href = "index.php/?action=AccesNonAutorisé";</script>'; ?>
        <?php }

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

    }//end execute()


}//end class
