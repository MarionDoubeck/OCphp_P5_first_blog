<?php
session_start();
//error_reporting(0);

use Dotenv\Dotenv;
use App\services\Get;
use App\Controllers\HomePosts;
use App\Controllers\PostList;
use App\Controllers\Login;
use App\Controllers\Logout;
use App\services\Session;
use App\Controllers\Register;
use App\Controllers\SinglePost;
use App\Controllers\AddComment;
use App\Controllers\AdminAllPosts;
use App\Controllers\AdminAddPost;
use App\Controllers\AdminPendingComments;
use App\Controllers\AdminValidatedComments;
use App\Controllers\AdminAllUsers;

// Autoload
require 'vendor/autoload.php';


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Router
try{

    if (Get::get('action') !== null && Get::get('action') !== '') {
        switch (Get::get('action')) {
        case "archive":
            (new PostList())->execute();
            break;
        case "login":
            (new Login())->execute();
            break;
        case "logout":
            (new Logout())->execute();
            break;
        case "register":
            if (null !==Session::get('user_id')) {
                throw new Exception(
                'Vous êtes déjà connecté, 
                vous ne pouvez pas vous inscrire à nouveau'
                );
            }
            (new Register())->execute();
            break;
        case "article":
            if (null !== Get::get('id') && get::get('id') > 0) {
                $identifier = Get::get('id');
                (new SinglePost())->execute($identifier);
            } else {
                    throw new Exception('aucun identifiant envoyé');
            }
            break;
        case "addComment":
            if (null !== Get::get('id') && Get::get('id') > 0) {
                $identifier = Get::get('id');
                (new AddComment())->execute($identifier);
            } else {
                    throw new Exception('aucun identifiant envoyé');
            }
            break;
        case "administration":
            if (null !== Session::get('user_id') && Session::get('role') == 'admin') {
                include 'app/views/admin/dashboard.php';
            } else {
                throw new Exception('Seul l\'administrateur a accès à cette page');
            }
            break;
        case "adminAllPosts":
            (new AdminAllPosts())->execute();
            break;
        case "adminAddPost":
            (new AdminAddPost())->execute();
            break;
        case "adminPendingComments":
            (new AdminPendingComments())->execute();
            break;
        case "adminValidatedComments":
            (new AdminValidatedComments())->execute();
            break;
        case "adminAllUsers":
            (new AdminAllUsers())->execute();
            break;
        default:
            include 'app/views/404.php';
        }
    
    
    } else {
        (new HomePosts())->execute();
    }

}catch (Exception $e) {
    $errorMessage = $e->getMessage();

    echo esc_html($errorMessage);
}



