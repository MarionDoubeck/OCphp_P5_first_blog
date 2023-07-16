<?php
namespace App\Controllers;

use App\Models\Post;
use App\db\DatabaseConnection;

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
        include 'app/views/home.php';
    }


}
