<?php
namespace App\Controllers;

use App\Models\Post;
use App\db\DatabaseConnection;
use App\helpers\Helpers;

/**
 * HomePosts class
 * To display last 3 posts on home page
 */
class HomePosts
{
    /**
     * Method in charge of displaying the last 3 posts
     *
     * @return void
     */

    public function execute()
    {
        $repository = new Post();
        $repository->connection = new DatabaseConnection();
        $lastThreePosts = $repository->getRecentPosts();
        $helper = new Helpers;
        $helper->renderView('app/views/home.php',['lastThreePosts'=>$lastThreePosts]);
    }


}
