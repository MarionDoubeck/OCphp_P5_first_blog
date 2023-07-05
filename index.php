<?php
session_start();

use Dotenv\Dotenv;
use App\views\Home;

//Autoload
require 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

var_dump((new Home)->getUserById(2));