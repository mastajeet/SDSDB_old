<?php

class Authorization{

    const KEY_AUTHORIZATION_LEVEL = "authorization_level";
    const KEY_PASSWORD = "password";
    const INCOMPLETE_COOKIE_FOR_AUTHORIZATION_VALIDATION = "Incomplete cookie for authorization validation";
    const AUTHORIZATION_LEVEL_SUPER_ADMIN = "super_admin";
    const AUTHORIZATION_LEVEL_BUREAU = "bureau";

    private $password_getter;

    function __construct($password_getter){
        $this->password_getter = $password_getter;
    }

    function verifySuperAdmin($cookie){
        if($this->are_all_login_credential_present($cookie)){
            if($this->is_authorization_level_super_admin($cookie)){
                if($this->is_super_admin_password_good($cookie)){
                    return(true);
                }else{
                    return(false);
                }
            }else{
                return(false);
            }
        }else{
            throw new MissingAuthorizationCredentialsException();
        }
    }

    private function is_super_admin_password_good($cookie){
        return $this->password_getter->get_super_admin_password()==$cookie[self::KEY_PASSWORD];
    }

    private function is_authorization_level_super_admin($cookie){
        return $cookie[self::KEY_AUTHORIZATION_LEVEL] == self::AUTHORIZATION_LEVEL_SUPER_ADMIN;
    }

    private function are_all_login_credential_present($cookie){
        return array_key_exists(self::KEY_AUTHORIZATION_LEVEL, $cookie) and array_key_exists(self::KEY_PASSWORD, $cookie);
    }


}

class MissingAuthorizationCredentialsException extends Exception{

}