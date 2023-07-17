<?php
namespace App\helpers;

/**
 * Helpers class
 * Contains helpers php functions
 */
use App\services\Session;


class Helpers
{

/**
 * Generate a CSRF token and store it in the session
 */
function generateCsrfToken()
{
    if (!isset($_SESSION)) {
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
    if (!isset($_SESSION)) {
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

/**
 * Function to replace include 'viewFile.phph' for security issues
 * 
 * @param string $viewPath
 * @param $data
 * 
 * 
 */

 function renderView($viewPath, $data = []) {
    extract($data); // Extrait les données pour les rendre accessibles dans la vue
    include $viewPath;
}
}