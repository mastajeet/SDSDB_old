<?php

use installation\InstallationService;
use installation\localDBConnector;

include_once('BaseModel.php');
include_once('func_divers.php');
include_once('app/responsable.php');
include_once('invoice/weeklyInvoice.php');
include_once('invoice/monthlyInvoice.php');

$INEXISTING_FACTURATION_FREQUENCE = "Le mode de facture n'existe pas";

class Customer extends BaseModel
{
    public $IDClient;
    public $Ferie;
    public $FrequenceFacturation;
    public $time_service;
    public $invoice_service;
    public $RespF;
    public $RespP;
    public $Nom;
    public $Cote;
    public $Adresse;
    public $Tel;
    public $Facturation;
    public $Fax;
    public $Email;
    public $TXH;

    public $dossier_facturation = null;
    public $responsables;

    static function get_all_customer_with_oustanding_balance($year, $tolerance=0.10){
        $sql = new SqlClass();
        $select_customer_query = "SELECT IDClient FROM client ORDER BY Nom ASC";
        $sql->select($select_customer_query);
        $customers = Array();
        while($customer_information = $sql->FetchAssoc()){
            $current_customer = new Customer($customer_information['IDClient']);
            if($current_customer->has_outstanding_balance($year, $tolerance)){
                $customers[] = $current_customer;
            }
        }

        return $customers;
    }

    function __construct($Arg = null)
    {
        parent::__construct($Arg);
        $variable = New Variable();
        $notes = $variable->get_value('NoteFacture');
        $tps = $variable->get_value('TPS');
        $tvq = $variable->get_value('TVQ');
        $this->responsables = array();
        if($this->RespP<>"0"){
            $this->responsables["responsable_piscine"] =new Responsable($this->RespP);
        }
        if($this->RespF<>"0"){
            $this->responsables["responsable_facturation"] = new Responsable($this->RespF);
        }
        $this->time_service = new TimeService();
        $this->invoice_service = new InvoiceService($notes, $tps, $tvq);
        $installationServiceDataSource = new localDBConnector(SqlClass::class); #TODO: customer / installation : il faut extraire cette dépendance
        $this->installationService = new InstallationService(0, $installationServiceDataSource); #TODO: customer / installation : il faut extraire cette dépendance
    }

    static function define_table_info(){
        return array("model_table" => 'client',
        "model_table_id" => 'IDClient');
    }

    static function define_data_types(){
        return array("IDCustomer"=>'ID',
            'timeService'=>'service',
            'facture_service'=>'service',
            'responsables' => 'has_many',
            'dossier_facturation' => 'has_one'
        );
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

    function update_facture(Invoice &$facture){
        foreach ($facture->Factsheet as $factsheet){
            $factsheet->update_using_customer_ferie($this->Ferie);
        }
    }

    function has_outstanding_balance($year, $tolerance){
        if(!isset($this->dossier_facturation)){
            $this->get_dossiers_facturation($year);
        }

        foreach($this->dossier_facturation as $dossier_facturation){
            if($dossier_facturation->has_outstanding_balance($tolerance)){
                return true;
            }
        }
        return false;
    }

    function get_installations(){
        $installations = Installation::get_all("IDClient=".$this->IDClient, "Nom", "ASC");

        return $installations;
    }

    public function generate_next_time_facture($cote_to_bill, $start_of_billable_time){
        $facture = null;
        $start_of_week_timestamp =$this->time_service->get_start_of_week($start_of_billable_time)->getTimestamp();
        $facture_information = array("Cote"=>$cote_to_bill,
            "Semaine"=>$start_of_week_timestamp,
            "TPS"=>get_vars('TPS'),
            "TVQ"=>get_vars('TVQ'),
            "Sequence"=>$this->invoice_service->get_next_shift_and_materiel_facture_sequence($cote_to_bill),
            "EnDate"=>time());

        if($this->FrequenceFacturation=="M"){
            $facture = new MonthlyInvoice($facture_information, $start_of_billable_time);
        }elseif($this->FrequenceFacturation=="H"){
            $facture = new WeeklyInvoice($facture_information);
        }else{
            throw new UnexpectedValueException(INEXISTING_FACTURATION_FREQUENCE);
        }

        return $facture;
    }

    function get_dossiers_facturation($year){
        $installations = Installation::get_installations_by_customer_id($this->IDClient);
        $this->dossier_facturation = array();
        foreach ($installations as $installation){
            if(!in_array($installation->Cote, $this->dossier_facturation) ){
                $this->dossier_facturation[$installation->Cote] = new DossierFacturation($installation->Cote, $year);
            }
        }
    }

    function generate_factures($cote, $startOfBillableTime){
        $customer = customer::find_customer_by_cote($cote);
        $installation_to_bill = Installation::get_installations_to_bill_by_cote($cote);
        $factures = array();
        foreach($installation_to_bill as $installation) {
            $facture = $this->generate_next_time_facture($cote, $startOfBillableTime);
            $shift_to_bill = $facture->get_billable_shift($installation);
            if(count($shift_to_bill)>0){
                $facture->save();
                foreach($shift_to_bill as $shift){
                    $shift->add_to_facture($facture);
                }
                $facture->invoice_items_updated = true;
                $facture->save();
                $customer->update_facture($facture);
                $facture->save();
                $factures[] = $facture;
            }
        }
        return $factures;
    }
}
