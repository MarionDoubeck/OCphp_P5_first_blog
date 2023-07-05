<?php
session_start();

use Dotenv\Dotenv;

//Autoload
require 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

include 'app/views/home.php';