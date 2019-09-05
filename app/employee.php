<?php

class Employee extends BaseModel
{

    public $Prenom;
    public $Nom;
    public $TelP;
    public $Cell;

    static function define_table_info(){
        return array("model_table" => "employe",
            "model_table_id" => "IDEmploye");
    }

    static function define_data_types(){
        return array("IDEmploye"=>'ID');
    }

    static function get_employee_list_for_session($session){
        $employee_list_query = "SELECT IDEmploye from employe where session = '{$session}'";
        return BaseModel::find($employee_list_query, Employee::class);
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