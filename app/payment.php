<?php

class Payment extends BaseModel
{

    public $Cote;
    public $Montant;
    public $Date;
    public $Notes;


    static function define_table_info(){
        return array("model_table" => "paiement",
            "model_table_id" => "IDPaiement");
    }

    static function define_data_types(){
        return array("IDPaiement"=>'ID');
    }

//    function isFacturePaid(facture $facture){
//
//    }

//    static function find_by_cote_and_sequence($cote, $sequence){
//        $facture_token = Payment::generate_facture_token($cote, $sequence);
//
//
//
//    }
//
//
//    static function generate_facture_token($cote, $sequence){
//
//        return $cote."-".$sequence;
//
//    }

}