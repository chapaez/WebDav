<?php
namespace Uni\WebDav;
/**
 * Class WebDavSecurity
 * @package Uni\WebDav
 */
class WebDavSecurity{
    /**
     * Simple base security check - send token to authenticate.
     * TODO improve security against MITM etc :)
     * @return bool
     */
    static function checkSalt(){
        return $_POST['salt']==WebDavConfigurator::getInstance()->getSalt();
    }

    /**
     * Simple base security check - send token to authenticate.
     * TODO OAUTH
     * @return bool
     */
    static function getToken(){
        return WebDavConfigurator::getInstance()->getSalt();
    }
}