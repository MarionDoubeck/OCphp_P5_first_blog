<?php
session_start();
//error_reporting(0);

use Dotenv\Dotenv;
use App\services\Get;
use App\Controllers\PostList;
use App\Controllers\HomePosts;

// Autoload
require 'vendor/autoload.php';


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Router
try{

    if (null !==Get::get('action') && Get::get('action') !== '') {
        switch (Get::get('action')) {
        case "archive":
            (new PostList())->execute();
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



