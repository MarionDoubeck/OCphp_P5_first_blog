<?php
session_start();
//error_reporting(0);

use Dotenv\Dotenv;
use App\services\Get;
use App\Controllers\HomePosts;
use App\Controllers\PostList;
use App\Controllers\Login;

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



