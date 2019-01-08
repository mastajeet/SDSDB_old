<?php
include_once('facture/factureService.php');
include_once('Variable.php');

class Payment extends BaseModel
{

    public $IDPaiement;
    public $Cote;
    public $Montant;
    public $Date;
    public $Notes;

    private $facture_service;

    function __construct($Arg = null){
        parent::__construct($Arg);

        $variable = New Variable();
        $notes = $variable->get_value('NoteFacture');
        $tps = $variable->get_value('TPS');
        $tvq = $variable->get_value('TVQ');
        $this->facture_service = new FactureService($notes, $tps, $tvq);
    }

    static function define_table_info(){
        return array("model_table" => "paiement",
            "model_table_id" => "IDPaiement");
    }

    static function define_data_types(){
        return array("IDPaiement"=>'ID');
    }
    

    function get_paid_facture(){

        $split_notes = explode("~", $this->Notes);
        $paid_facture = [];

        foreach($split_notes as $notes_element){
            $needle = $this->Cote."-";
            $facture_sequence = str_replace($needle, '', strstr($notes_element,$needle));
            if($facture_sequence) {
                $facture = $this->facture_service->get_shift_and_materiel_facture_by_cote_and_sequence($this->Cote, intval($facture_sequence));
                $paid_facture[$facture->IDFacture] = $facture;
            }
        }

        return $paid_facture;
    }

    function get_payment_balance($factures){

        $montant_left = -$this->Montant;
        foreach($factures as $idfacture => $facture){
            $facture_balance = $facture->get_balance();
            $montant_left +=  $facture_balance["total"];
        }

        return $montant_left;
    }

    function paid_facture(Facture $facture){
        $paid_factures = $this->get_paid_facture();
        $paid = false;
        foreach ($paid_factures as $id_facture => $paid_facture){
            if($id_facture == $facture->IDFacture){
                $paid = true;
            }
        }

        return $paid;
    }
}
