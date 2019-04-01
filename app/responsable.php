<?php

class Responsable extends BaseModel {

    public $full_name;

    public $Nom;
    public $Prenom;
    public $Titre;
    public $IDResponsable;

    static function define_table_info(){
        return array("model_table" => "responsable",
            "model_table_id" => "IDResponsable");
    }

    static function define_data_types(){
        return array("IDResponsable"=>'ID');
    }

    function __construct($Arg = null){
        parent::__construct($Arg);
        $this->full_name = $this->Titre." ".$this->Prenom." ".$this->Nom;
    }


}