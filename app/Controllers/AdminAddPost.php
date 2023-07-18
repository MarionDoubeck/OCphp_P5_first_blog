<?php
namespace App\Controllers;
use App\services\Helpers;
use App\Models\Post;
use App\services\Session;
use App\services\PostGlobal;
use App\services\Files;
use App\services\Server;
use App\db\DatabaseConnection;

/**
 * AdminAddPost class
 * To add a new post in the admin part
 */
class AdminAddPost {
    /**
     * Method to add a new post
     *
     * @return void
     */
    public function execute()
    {
        $helper = new Helpers;
        $role = Session::get('role');
        $user_id = Session::get('user_id');
        $content = null;
        $title = null;
        $chapo = null;

        if ($role !='admin') {
            throw new \Exception('Page résevée à l\'administration !');
        }
        if (Server::requestMethod() === 'POST')  {
            if ($helper->validateCsrfToken(PostGlobal::get('csrf_token')) === FALSE) {
                throw new \Exception("Erreur : Jeton CSRF invalide.");
            } else {
                // We do the checks.
                if (empty(PostGlobal::get('content')) === FALSE && empty(PostGlobal::get('title')) === FALSE
                    && empty(PostGlobal::get('chapo')) === FALSE )
                {
                    $content = strip_tags(PostGlobal::get('content'));
                    $title = strip_tags(PostGlobal::get('title'));
                    $chapo = strip_tags(PostGlobal::get('chapo'));
                    // Check if an image was uploaded
                    if (empty(Files::file('image','tmp_name')) === FALSE ) {
                        // Process the uploaded image without codacy discouraged function file_get_contents.
                        //$image_data = file_get_contents(Files::file('image','tmp_name'));
                        $fileHandle = fopen(Files::file('image','tmp_name'), 'rb');
                        $image_data = fread($fileHandle, Files::filesize('image','tmp_name'));
                        fclose($fileHandle);
                        $image_type = Files::file('image','tmp_name');
                    } else {
                        $image_data = null;
                        $image_type = null;
                    }
                } else {
                    ?>
                    <script language="javascript"> 
                        alert("les données du formulaire sont invalides");
                        document.location.href = '/index.php?action=adminAddPost';
                    </script>
                    <?php
                }

                // We create the new article.
                $postRepository = new Post();
                $postRepository->connection = new DatabaseConnection();
                $success = $postRepository->addPost($title, $content, $chapo, $user_id, $image_data, $image_type);
                if ($success === FALSE) {
                    throw new \Exception('Impossible d\'ajouter l\'article !');
                } else {
                    ?>
                    <script language="javascript"> 
                    alert("article ajouté");
                    document.location.href = '/index.php?action=adminAllPosts';
                    </script>
                    <?php
                }
            }
        }
        
        $helper->renderView('app/views/admin/add-post.php',[]); 
    }
}