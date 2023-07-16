<?php

namespace App\services;

/**
 * Class postsuperglobal
 * postsuperglobal handler
 */
class PostGlobal
{

    /**
     * Put the $_POST values
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public static function put($key, $value)
    {
        $_POST[$key] = $value;
    }

    /**
     * Get the $_POST values
     *
     * @param  $key
     * @return void
     */
    public static function get($key)
    {
        return $_POST[$key] ?? null;
    }

    /**
     * Check if parameter of the $_POST is set
     *
     * @param  void $param
     * @return boolean
     */
    public static function isParamSet($param): bool
    {
        return isset($_POST[$param]);
    }

    /**
     * Get all the $_POST values
     *
     * @return void
     */
    public static function getAllPostVars()
    {
        return $_POST;
    }

}
