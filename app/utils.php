<?php
namespace Portal;

class Utils
{
    /* Session-related utils */

    static function setSession($sessionKey, $sessionValue)
    {
        $_SESSION[$sessionKey] = $sessionValue;
    }

    static function issetSession($sessionKey)
    {
        return isset($_SESSION[$sessionKey]);
    }

    static function getSession($sessionKey)
    {
        return $_SESSION[$sessionKey];
    }

    static function removeSession($sessionKey)
    {
        unset($_SESSION[$sessionKey]);
    }
}
