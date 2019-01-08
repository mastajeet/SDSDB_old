<?php

class Facture extends BaseModel
{
    public $Credit;
    public $Debit;
    public $Materiel;
    public $AvanceClient;

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

    static function get_last_facture_query(){
        throw new NotImplementedException();
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
            throw new RuntimeException("Can't find payment for paid facture ".$this->Cote."-".$this->Sequence);
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

    function is_debit(){
        return $this->Debit==1;
    }

    function is_avance_client(){
        return $this->AvanceClient==1;
    }

    function is_paid(){
        return $this->Paye==1;
    }

    function is_materiel(){
        return $this->Materiel==1;
    }

    function is_utilise(){
        return $this->Utilise==1;
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
