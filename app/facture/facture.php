<?php

class Facture extends BaseModel
{
    public $Credit = false;
    public $Materiel = false;

    public $IDFacture;
    public $Sequence;
    public $Semaine;
    public $TVQ;
    public $TPS;
    public $STotal;
    public $Factsheet;
    public $EnDate;
    public $Cote;
    public $BonAchat;

    function __construct($Args){
        parent::__construct($Args);
        $this->Factsheet = array();
    }

    static function get_last_for_cote($Cote, $Credit=0){
        $database_information = Facture::define_table_info();
        $last_facture_query = "SELECT IDFacture FROM ".$database_information['model_table']." WHERE Cote='".$Cote."' and Credit=".$Credit." ORDER BY Sequence DESC LIMIT 0,1";
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

    static function get_by_cote_and_sequence($cote, $sequence){
        $database_information = Facture::define_table_info();
        $facture_query = "SELECT ".$database_information['model_table_id']." FROM ".$database_information['model_table']." WHERE Cote='".$cote."' and Sequence=".$sequence." and Credit=0";
        $SQL = new SQLClass();
        $SQL->Select($facture_query);
        $facture_id_cursor = $SQL->FetchArray();
        $facture = new Facture($facture_id_cursor["IDFacture"]);

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

    function get_payment($payments){
        $payment_that_paid_this_facture = null;
        foreach($payments as $id_payment => $payment){
            if($payment->paid_facture($this)){
                $payment_that_paid_this_facture = $payment;
            }
        }

        if(is_null($payment_that_paid_this_facture)){
            throw new RuntimeException("Unpaid facture asking for payment");
        }

        return $payment_that_paid_this_facture;
    }

    function get_balance(){
        $balance= Array("sub_total"=>0, "tps"=>0, "tvq"=>0, "total"=>0);

        $balance["sub_total"] = $this->STotal;
        $balance["tps"] = round($balance["sub_total"] * $this->TPS, 2);
        $balance["tvq"] = round(($balance["sub_total"]+$balance["tps"]) * $this->TVQ, 2);
        $balance["total"] = $balance["sub_total"] + $balance["tps"] + $balance["tvq"];

        return $balance;
    }

    function is_credit(){
        return $this->Credit==1;
    }

    function is_paid(){
        return $this->Paye==1;
    }

    function is_materiel(){
        return $this->Materiel==1;
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
        return array("IDFacture" => 'ID',
            "Factsheet" => 'has_many');
    }

}
