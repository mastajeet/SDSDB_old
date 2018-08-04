<?php
include_once('BaseModel.php');
include_once('func_divers.php');

include_once ('facture/facture_hebdomadaire.php');
include_once ('facture/facture_mensuelle.php');

$INEXISTING_FACTURATION_FREQUENCE = "Le mode de facture n<existe pas";

class Customer extends BaseModel
{
    public $IDClient;
    public $Ferie;
    public $FrequenceFacturation;
    public $time_service;

    function __construct($Arg = null)
    {
        parent::__construct($Arg);
        $this->time_service = new TimeService();
    }

    static function define_table_info(){
        return array("model_table" => 'client',
        "model_table_id" => 'IDClient');
    }

    static function find_customer_by_cote($cote){
        $sql = new SqlClass();
        $query = "SELECT client.IDClient from client JOIN installation on installation.IDClient = client.IDClient WHERE installation.Cote ='".$cote."'";
        $sql->Select($query);
        if($sql->NumRow()==0){
            throw new InvalidArgumentException(NO_CLIENT_ASSOCIATED_WITH_COTE." ".$cote);
        }
        $customer_id = $sql->FetchArray()['IDClient'];

        return new Customer($customer_id);
    }

    function update_facture(&$facture){
        foreach ($facture->Factsheet as $factsheet){
            $factsheet->update_using_customer_ferie($this->Ferie);
        }
    }

    function get_installations(){
        $installations = Installation::get_all("IDClient=".$this->IDClient, "Nom", "ASC");

        return $installations;
    }

    private function get_new_facture_sequence($cote){
        $last_facture = Facture::get_last_for_cote($cote);
        $last_sequence = $last_facture->Sequence;
        $next_sequence = $last_sequence + 1;
        return $next_sequence;
    }

    public function generate_next_time_facture($cote_to_bill, $start_of_billable_time){
        $facture = null;
        $start_of_week_timestamp =$this->time_service->get_start_of_week($start_of_billable_time)->getTimestamp();
        $facture_information = array("Cote"=>$cote_to_bill,
            "Semaine"=>$start_of_week_timestamp,
            "TPS"=>get_vars('TPS'),
            "TVQ"=>get_vars('TVQ'),
            "Sequence"=>$this->get_new_facture_sequence($cote_to_bill),
            "EnDate"=>time());

        if($this->FrequenceFacturation=="M"){
            $facture = new FactureMensuelle($facture_information, $start_of_billable_time);
        }elseif($this->FrequenceFacturation=="H"){
            $facture = new FactureHebdomadaire($facture_information);
        }else{
            throw new UnexpectedValueException(INEXISTING_FACTURATION_FREQUENCE);
        }

        return $facture;
    }

    function generate_factures($Cote, $start_of_billable_time){
        $customer = customer::find_customer_by_cote($Cote);
        $installation_to_bill = Installation::get_installations_to_bill($Cote);
        $factures = array();

        foreach($installation_to_bill as $installation) {
            $facture = $this->generate_next_time_facture($Cote, $start_of_billable_time);
            $shift_to_bill = $facture->get_billable_shift($installation);
            if(count($shift_to_bill)>0){
                $facture->save();
                foreach($shift_to_bill as $shift){
                    $shift->add_to_facture($facture);
                }
            }
            $facture->save();
            $customer->update_facture($facture);
            $facture->save();
            $factures[] = $facture;
        }

        return $factures;
    }

}