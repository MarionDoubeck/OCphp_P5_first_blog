<?php
namespace App\services;

/**
 * Get class
 * Getsuperglobal handler
 */
class Env
{

    /**
     * Put the $_ENV values
     *
     * @param  $key
     * @param  $value
     * @return void
     */
    public static function put($key, $value)
    {
        $_ENV[$key] = $value;
    }

    /**
     * Get the $_ENV values
     *
     * @param  [type] $key
     * @return void
     */
    public static function get($key)
    {
        return (isset($_ENV[$key]) ? $_ENV[$key] : null);
    }

   
}