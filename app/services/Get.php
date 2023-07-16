<?php
namespace App\services;

/**
 * Get class
 * Getsuperglobal handler
 */
class Get
{

    /**
     * Put the $_GET values
     *
     * @param  $key
     * @param  $value
     * @return void
     */
    public static function put($key, $value)
    {
        $_GET[$key] = $value;
    }

    /**
     * Get the $_GET values
     *
     * @param  [type] $key
     * @return void
     */
    public static function get($key)
    {
        return (isset($_GET[$key]) ? $_GET[$key] : null);
    }

   
}
