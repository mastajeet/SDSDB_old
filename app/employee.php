<?php

class Employee extends BaseModel
{

    public $Prenom;
    public $Nom;

    static function define_table_info(){
        return array("model_table" => "employe",
            "model_table_id" => "IDEmploye");
    }

    static function define_data_types(){
        return array("IDEmploye"=>'ID');
    }

    public function initials(){
        $Initiales = "";

        foreach(explode('-',$this->Prenom) as $v){
            $Initiales .= substr($v,0,1);
        }

        foreach(explode('-',$this->Nom) as $v){
            $Initiales .= substr($v,0,1);
        }

        return $Initiales;
    }

}