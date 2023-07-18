<?php
namespace App\Controllers;

use App\Models\Comment;
use App\db\DatabaseConnection;
use App\services\Session;
use App\services\PostGlobal;
use App\services\Helpers;

/**
 * AddComment class
 * To add a new comment after checking
 */
class AddComment
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
     * @param Session    $session Session
     * @param PostGlobal $postGlobal PostGlobal
     * 
     * @return void
     */
    public function __construct(Session $session, PostGlobal $postGlobal)
    {
        $this->session = $session;
        $this->postGlobal = $postGlobal;
    }


    /**
     * Function in charge of doing security checks and adding a new comment
     *
     * @param int $postId PostId
     *
     * @return void
     */
    public function execute(int $postId)
    {
        $user_id = $this->session->get('user_id');
        $commentContent = null;

        $helper = new Helpers;
        // We do the checks.
        if (empty($this->postGlobal->get('commentContent')) === false) {
            try {
                /* Check if the CSRF token is valid */
                if ($helper->validateCsrfToken($this->postGlobal->get('csrf_token')) === FALSE) {
                    throw new \Exception("Erreur : Jeton CSRF invalide.");
                } else {
                    $commentContent = strip_tags($this->postGlobal->get('commentContent'));
                }
            } catch (Exception $e) {
                $errorMessage = "Une erreur s'est produite : " . $e->getMessage();
                echo htmlspecialchars($errorMessage);
            }
        } else {
            ?>
            <script language="javascript"> 
            var numpost = <?= $postId?>;
            alert("les données du commentaires sont invalides");
            document.location.href = '/index.php?action=article&id='+numpost;</script>
            <?php
        }

        // We create a new comment.
        $commentRepository = new Comment();
        $commentRepository->connection = new DatabaseConnection();
        $success = $commentRepository->createComment($postId, $user_id, $commentContent);
        if ($success === FALSE) {
            throw new \Exception('Impossible d\'ajouter le commentaire !');
        } else {
            ?>
            <script language="javascript"> 
            var numpost = <?= $postId ?>;
            alert("Commentaire envoyé, celui-ci sera visible après validation.");
            document.location.href = '/index.php?action=article&id='+numpost;</script>
            <?php
        }
    }


}
