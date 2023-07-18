<?php
namespace App\Controllers;

use App\services\Session;

/**
 * Logout class
 * To logout the user
 */
class Logout
{


    /**
     * Method to user logout
     *
     * @return void
     */
    public function execute()
    {
        $session = new Session;
        $session->destroySession();
        ?>
        <script>
            history.go(-1);
        </script>
        <?php

    }//end execute()


}//end class
