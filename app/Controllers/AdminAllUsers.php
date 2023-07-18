<?php
namespace App\Controllers;

use App\Models\User;
use App\services\Session;
use App\db\DatabaseConnection;
use App\services\Helpers;

/**
 * AdminUserlist class
 * To manage users in admin part
 */
class AdminAllUsers
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
     * Method in charge of displaying the list of users
     *
     * @return void
     */
    public function execute()
    {
        $role = $this->session->get('role');
        $helper = new Helpers;
        if ($role !== 'admin') {
            header("Location: index.php/?action=AccesNonAutorisé");
        }

        $repository = new User();
        $repository->connection = new DatabaseConnection();
        $users = $repository->getUsers();

        $helper->renderView('app/views/admin/all-users.php',['users' => $users]);

    }//end execute()


}//end class
