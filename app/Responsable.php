<?php

class Responsable extends BaseModel {

    public $nom_complet;

    public $Nom;
    public $Prenom;
    public $IDResponsable;

    static function define_table_info(){
        return array("model_table" => "responsable",
            "model_table_id" => "IDResponsable");
    }

    static function define_data_types(){
        return array("IDResponsable"=>'ID');
    }

    function __construct($Arg = null)
    {
        parent::__construct($Arg);
        $this->nom_complet = $this->Nom." ".$this->Prenom;
    }


}