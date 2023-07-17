<?php
namespace App\Controllers;

use App\Models\Post;
use App\db\DatabaseConnection;
use App\helpers\Helpers;

/**
 * PostList class
 * To display all posts on the blog page
 */
class PostList
{
    /**
     * Method in charge of displaying the list of posts
     *
     * @return void
     */

    public function execute()
    {
        $repository = new Post();
        $repository->connection = new DatabaseConnection();
        $posts = $repository->getPosts();
        $helper = new Helpers;
        $helper->renderView('app/views/articles.php',['posts' =>$posts]);
    }


}
