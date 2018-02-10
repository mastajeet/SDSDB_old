<?php

class Facture extends BaseModel
{
    public $credit = false;
    public $materiel = false;
    public $IDFacture;
    public $Semaine;
    public $Factsheet;

    function __construct($Args){
        parent::__construct($Args);
        $this->Factsheet = array();
    }

    static function get_last_for_cote($Cote, $Materiel=0, $Credit=0){
        $database_information = Facture::define_table_info();
        $last_facture_query = "SELECT IDFacture FROM ".$database_information['model_table']." WHERE Cote='".$Cote."' and Materiel=".$Materiel." and Credit=".$Credit." ORDER BY Sequence DESC LIMIT 0,1";
        $SQL = new SQLClass();
        $SQL->Select($last_facture_query);
        $facture = new Facture([]);
        if($SQL->NumRow()>0){
            $facture_response = $SQL->FetchArray();
            $facture_id = intval($facture_response[$database_information['model_table_id']]);
            $facture = new Facture($facture_id);
        }
        return $facture;
    }

    function update_balance(){
        $balance = 0;
        foreach($this->Factsheet as $factsheet){
            $factsheet->add_factshift_to_balance($balance);
        }
        $this->STotal = $balance;
    }

    function save(){
        $this->update_balance();
        parent::save();
    }

    function add_factsheet(&$factsheet){
        $this->Factsheet[] = $factsheet;
        $this->add_to_updated_values("Factsheet");
    }

    static function define_table_info(){
        return array("model_table" => "facture",
            "model_table_id" => "IDFacture");
    }

    static function define_data_types(){
        return array("IDFacture"=>'ID',
            "Factsheet"=>'has_many');
    }

}