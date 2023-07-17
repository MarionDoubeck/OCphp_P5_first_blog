<?php
namespace App\Controllers;
use App\helpers\Helpers;


class AdminAddPost {
    public function execute()
    {
        $helper = new Helpers;
        $helper->renderView('app/views/admin/add-post.php',[]); 
    }
}