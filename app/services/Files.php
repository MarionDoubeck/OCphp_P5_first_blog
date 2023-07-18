<?php
namespace App\services;

/**
 * Files class
 * Filessuperglobal handler
 */
class Files
{
    /**
     * Put the $_GET values
     *
     * @param  $key
     * @param  $value
     * @return void
     */
    public static function files($type, $temporaryName)
    {
        return $_FILES[$type][$temporaryName];
    }
}