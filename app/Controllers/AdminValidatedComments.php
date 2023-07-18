<?php
namespace App\Controllers;
use App\Models\Comment;
use App\services\Session;
use App\db\DatabaseConnection;
use App\services\Helpers;

class AdminValidatedComments
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
     * @param Session    $session Session
     * 
     * @return void
     */
    public function __construct(Session $session)
    {
        $this->session = $session;

    }


    /**
     * Method in charge of displaying the list of unvalidaded comments
     * for the admin
     *
     * @return void
     */
    public function execute()
    {
        $role = Session::get('role');
        if ($role !== 'admin') {
            $helper->renderView('app/views/404.php',[]);
        }
        
        $repository = new Comment();
        $repository->connection = new DatabaseConnection();
        $comments = $repository->getCommentsStatus('approved');

        $helper = new Helpers;
        $helper->renderView('app/views/admin/validated-comments.php',['comments' => $comments]);

    }//end execute()


}
