<?php

class Employee extends BaseModel
{
    public $IDEmploye;
    public $Prenom;
    public $Nom;
    public $NAS;
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

    function __construct($Arg = null)
    {
        if($this->isNullEmploye($Arg))
        {
            parent::__construct($this->getNullEmployeeValues());
        } else {
            parent::__construct($Arg);
        }
    }

    private function isNullEmploye($Arg)
    {
        if(is_numeric($Arg) and $Arg==0)
        {
            return true;
        }
        return false;
    }

    private function getNullEmployeeValues()
    {
        return Array(
            'IDEmploye'=>0,
            'Nom'=>"",
            'Prenom'=>"",
            'NAS'=>"123321090"
        );
    }
}