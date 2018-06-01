<?php

class Employee extends BaseModel
{

    static function define_table_info(){
        return array("model_table" => "employe",
            "model_table_id" => "IDEmploye");
    }

    static function define_data_types(){
        return array("IDEmploye"=>'ID');
    }

}