<?php
namespace App\Controllers;

use App\Models\User;
use App\services\Session;
use App\db\DatabaseConnection;

/**
 * AdminUserlist class
 * To manage users in admin part
 */
class AdminAllUsers
{
    /**
     * Method in charge of displaying the list of users
     *
     * @return void
     */


    public function execute()
    {
        $role = Session::get('role');
        if ($role !='admin') {
            throw new \Exception('Page résevée à l\'administration !');
        }
        $repository = new User();
        $repository->connection = new DatabaseConnection();
        $users = $repository->getUsers();

        include 'app/views/admin/all-users.php';        
    }
}