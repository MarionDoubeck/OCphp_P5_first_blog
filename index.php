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
        default:
            include 'app/views/404.php';
        }
    
    
    } else {
        (new HomePosts())->execute();
    }

}catch (Exception $e) {
    $errorMessage = $e->getMessage();

    echo $errorMessage;
}



