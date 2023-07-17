<?php
namespace App\services;

/**
 * Class Session
 * session handler
 */
class Session
{
    /**
     * Put the session values
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get the session values
     *
     * @param  string $key
     * @return void
     */
    public static function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Check if parameter of the session is set
     *
     * @param  string $param
     * @return boolean
     */
    public static function isParamSet($param) : bool
    {
        return isset($_SESSION[$param]);
    }

    /**
     * Remove element from the session
     *
     * @param  [type] $key
     * @return void
     */
    public static function forget($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Remove all session's values
     *
     * @return void
     */
    public function unsetAll()
    {
        session_unset();
    }

    /**
     * Unset all the datat and destroy session
     *
     * @return void
     */
    public function destroySession()
    {
        $this->unsetAll();
        session_destroy();
    }

}
