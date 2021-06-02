<?php
namespace SDSApi;

class ApiConnectionBaseInfo{
    public $password;
    public $companyId;

    function __construct($request){
        $this->password = strval($request["password"]);
        $this->companyId = intval($request["company_id"]);
    }

    function isAuthorized(){
        $isAuthorized = false;
        if($this->password == "jaimelesminous"){
            return true;
        }

        return $isAuthorized;
    }
}