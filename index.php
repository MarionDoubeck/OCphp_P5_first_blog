<?php
session_start();

use Dotenv\Dotenv;
use App\services\Get;
use App\Controllers\HomePosts;
use App\Controllers\PostList;
use App\Controllers\Login;
use App\Controllers\Logout;
use App\services\Session;
use App\services\Server;
use App\services\PostGlobal;
use App\services\Files;
use App\services\Helpers;
use App\Controllers\Register;
use App\Controllers\SinglePost;
use App\Controllers\AddComment;
use App\Controllers\AdminAllPosts;
use App\Controllers\AdminAddPost;
use App\Controllers\AdminPendingComments;
use App\Controllers\AdminValidatedComments;
use App\Controllers\AdminAllUsers;
use App\Controllers\DeleteComment;
use App\Controllers\ValidateComment;
use App\Controllers\DeletePost;
use App\Controllers\EditPost;

// Autoload.
require 'vendor/autoload.php';


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$helper = new Helpers;

// To avoid static access of services classes functions, call classes with construction parameters.
$session = new Session();
$postGlobal = new PostGlobal();
$server = new Server();
$files = new Files();

// Router.
try {
    if (Get::get('action') !== null && Get::get('action') !== '') {
        switch (Get::get('action')) {
        case "archive":
            (new PostList())->execute();
            break;
        case "login":
            (new Login($session, $postGlobal, $server))->execute();
            break;
        case "logout":
            (new Logout())->execute();
            break;
        case "register":
            if (Session::get('user_id') !== null) { ?>
                <script>
                    alert('Vous êtes déjà connecté, vous ne pouvez pas vous inscrire à nouveau')
                    window.location.reload();
                </script>
            <?php }

            (new Register($session, $postGlobal))->execute();
            break;
        case "article":
            if (Get::get('id') !== null && get::get('id') > 0) {
                $identifier = Get::get('id');
                (new SinglePost())->execute($identifier);
            } else {?>
                <script> 
                    alert('Aucun identifiant de post envoyé')
                    window.location.reload();
                </script>
            <?php }
            break;
        case "addComment":
            if (Get::get('id') !== null && Get::get('id') > 0) {
                $identifier = Get::get('id');
                (new AddComment($session, $postGlobal))->execute($identifier);
            } else {?>
                <script> 
                    alert('Aucun identifiant de post envoyé')
                    window.location.reload();
                </script>
            <?php }
            break;
        case "administration":
            if (Session::get('user_id') !== null && Session::get('role') === 'admin') {
                $helper->renderView('app/views/admin/dashboard.php',[]);
            } else {
                $helper->renderView('app/views/404.php',[]);
            }
            break;
        case "adminAllPosts":
            (new AdminAllPosts($session))->execute();
            break;
        case "adminAddPost":
            (new AdminAddPost($session, $postGlobal, $server, $files))->execute();
            break;
        case "adminPendingComments":
            (new AdminPendingComments($session))->execute();
            break;
        case "adminValidatedComments":
            (new AdminValidatedComments($session))->execute();
            break;
        case "adminAllUsers":
            (new AdminAllUsers($session))->execute();
            break;
        case "deleteComment":
            if (Get::get('id') !== null && Get::get('id') > 0) {
                $identifier = Get::get('id');
                (new DeleteComment($session))->execute($identifier);
            } else {
                throw new Exception('aucun identifiant envoyé');
            }
            break;
        case "validateComment":
            if (Get::get('id') !== null  && Get::get('id') > 0) {
                $identifier = Get::get('id');
                (new ValidateComment($session))->execute($identifier);
            } else {
                throw new Exception('aucun identifiant envoyé');
            }
            break;
        case "deletePost":
            if (Get::get('id') !== null  && Get::get('id') > 0) {
                $identifier = Get::get('id');
                (new DeletePost($session, $postGlobal))->execute($identifier);
            } else {
                throw new Exception('aucun identifiant envoyé');
            }
            break;
        case "editPost":
            if (Get::get('id') !== null  && Get::get('id') > 0) {
                $identifier = Get::get('id');
                $input = null;
                if (Server::requestMethod() === 'POST') {
                    $input = PostGlobal::getAllPostVars();
                }

                (new EditPost($session, $files))->execute($identifier, $input);
            } else {
                    throw new Exception('aucun identifiant envoyé');
            }
            break;
        default:
            $helper->renderView('app/views/404.php',[]);
        }// end switch
    } else {
        (new HomePosts())->execute();
    }// end if
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    echo htmlspecialchars($errorMessage);
}// end try