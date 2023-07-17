<?php
namespace App\Controllers;
use App\Models\Comment;
use App\services\Session;
use App\db\DatabaseConnection;
use App\helpers\Helpers;

class AdminValidatedComments {
    /**
     * Method in charge of displaying the list of unvalidaded comments
     * for the admin
     *
     * @return void
     */


    public function execute()
    {
        $role = Session::get('role');
        if ($role !='admin') {
            throw new \Exception('Page résevée à l\'administration !');
        }
        $repository = new Comment();
        $repository->connection = new DatabaseConnection();
        $comments = $repository->getCommentsStatus('approved');

        $helper = new Helpers;
        $helper->renderView('app/views/admin/validated-comments.php',['comments'=>$comments]);
    }
}