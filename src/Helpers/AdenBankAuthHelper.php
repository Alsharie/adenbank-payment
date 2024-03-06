<?php

namespace Alsharie\AdenBankPayment\Helpers;


class AdenBankAuthHelper
{


    private static $auth_session_name = 'ADENBANK_LOGIN_ACCESS_TOKEN';

    public static function setAuthToken($token)
    {
        $_SESSION[self::$auth_session_name] = $token;
    }

    public static function getAuthToken()
    {
        if (isset($_SESSION[self::$auth_session_name]))
            return $_SESSION[self::$auth_session_name];
        return null;
    }


}