<?php
namespace App\services;

/**
 * Files class
 * Filessuperglobal handler
 */
class Files
{
    /**
     * Get download file data
     *
     * @param  string $type
     * @param  string $temporaryName
     * @return array
     */
    public static function files($type, $temporaryName)
    {
        return $_FILES[$type][$temporaryName];
    }

    /**
     * Get download file size
     * 
     * @param  string $type
     * @param  string $temporaryName
     * @return int
     */
    public static function getFileSize($type, $temporaryName)
    {
        return filesize($_FILES[$type][$temporaryName]);
    }

    /**
     * Get download file content
     * 
     * @param  string $type
     * @param  string $temporaryName
     * @return string
     */
    public static function getFileContent($type, $temporaryName)
    {
        return file_get_contents($_FILES['image']['tmp_name']);
    }

    /**
     * read file content
     * 
     * @param  string $type
     * @param  string $temporaryName
     * @return array
     */
    public static function file($type, $temporaryName)
    {
        return ($_FILES['image']['tmp_name']);
    }
}