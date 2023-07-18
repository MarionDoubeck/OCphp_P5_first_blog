<?php
namespace App\Controllers;

use App\Models\Post;
use App\services\Session;
use App\db\DatabaseConnection;
use App\services\Helpers;

/**
 * AdminPostlist class
 * To manage posts in admin part
 */
class AdminAllPosts
{


    /**
     * Method in charge of displaying the list of posts
     *
     * @return void
     */
    public function execute()
    {
        $role = Session::get('role');
        if ($role !== 'admin') {
            $helper->renderView('app/views/404.php',[]);
        }
        
        $repository = new Post();
        $repository->connection = new DatabaseConnection();
        $posts = $repository->getPosts();
        $newPost = new Post();
        $newPost->connection = new DatabaseConnection();

        $helper = new Helpers;
        $helper->renderView('app/views/admin/all-posts.php', ['posts' => $posts, 'newPost' => $newPost]);

    }//end execute()


}
