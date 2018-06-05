<?php

class Secteur extends BaseModel {

    public $IDSecteur;
    public $Nom;

    static function define_table_info(){
        return array("model_table" => "secteur",
            "model_table_id" => "IDSecteur");
    }

    static function define_data_types(){
        return array("IDSecteur"=>'ID');
    }

}