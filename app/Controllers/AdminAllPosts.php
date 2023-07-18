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
     * Method in charge of displaying the list of posts
     *
     * @return void
     */
    public function execute()
    {
        $role = $this->session->get('role');
        if ($role !== 'admin') {
            echo '<script>window.location.href = "index.php/?action=AccesNonAutorisé";</script>';
        }

        $repository = new Post();
        $repository->connection = new DatabaseConnection();
        $posts = $repository->getPosts();
        $newPost = new Post();
        $newPost->connection = new DatabaseConnection();

        $helper = new Helpers;
        $helper->renderView('app/views/admin/all-posts.php', ['posts' => $posts, 'newPost' => $newPost]);

    }//end execute()


}//end class
