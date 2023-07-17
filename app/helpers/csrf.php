<?php
use App\services\Session;

/**
 * Generate a CSRF token and store it in the session
 */
function generateCsrfToken()
{
    if(!isset($_SESSION)){
        if (!isset($_SESSION)) {
            session_start();
        }
    }
    if (!Session::isParamSet('csrf_token')) {
        Session::put('csrf_token', bin2hex(random_bytes(32)));
    }
}

/**
 * Check if a CSRF token is valid
 * @param string $token The CSRF token to validate
 * @return bool True if the token is valid, False otherwise
 */
function validateCsrfToken($token)
{
    if(!isset($_SESSION)){
        if (!isset($_SESSION)) {
            session_start();
        }
    }
    if (!Session::isParamSet('csrf_token')) {
        return false;
    }

    // Check if the submitted token matches the one stored in the session
    return hash_equals(Session::get('csrf_token'), $token);
}

