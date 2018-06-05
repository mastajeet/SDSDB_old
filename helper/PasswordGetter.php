<?php

class PasswordGetter{

    private $variable;

    public function __construct($variable){
        $this->variable = $variable;
    }

    public function get_super_admin_password(){
        return $this->variable->get_super_admin_password();
    }
}