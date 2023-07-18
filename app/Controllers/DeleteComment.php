<?php
namespace App\Controllers;

use App\Models\Comment;
use App\services\Session;
use App\services\Helpers;
use App\db\DatabaseConnection;

/**
 * DeleteComment class
 * To delete comment in the admin part
 */
class DeleteComment
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
     * Method to delete a comment
     *
     * @param int $identifier Comment Id
     *
     * @return void
     */
    public function execute(int $identifier)
    {
        $role = $this->session->get('role');
        if ($role !== 'admin') {
            $helper = new Helpers;
            $helper->renderView('app/views/404.php',[]);
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

    }//end execute()


}//end class
