<?php
namespace App\services;

/**
 * Class Seever
 * server handler
 */
class Server
{
    /**
     * Get the server request method
     *
     * @return null||string
     */
    public static function requestMethod()
    {
        return ($_SERVER['REQUEST_METHOD']);
    }
}