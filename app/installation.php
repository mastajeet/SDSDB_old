<?php
include_once('BaseModel.php');
class Installation extends BaseModel
{
    public $IDInstallation;
    public $IDClient;
    public $IDResponsable;
    public $IDHoraire;
    public $IDSecteur;
    public $Cote;
    public $Nom;
    public $Tel;
    public $Lien;
    public $Adresse;
    public $Notes;
    public $Actif;
    public $IDType;
    public $Punch;
    public $Toilettes;
    public $Assistant;
    public $Cadenas;
    public $Balance;
    public $Saison;
    public $Seq;
    public $Seqc;
    public $Factname;
    public $ASFact;
    public $AdresseFact;
    public $Inspections;
    public $PONo;
    public $Stationnement;

    static function define_table_info(){
        return array("model_table" => 'installation',
                     "model_table_id" => 'IDInstallation');
    }

    static function get_installations_to_bill_by_cote($cote){
        $SQL = new sqlclass;
        $Req = "SELECT installation.IDInstallation, sum(shift.Facture) as isBilled FROM shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE `Cote`='".$cote."' GROUP BY installation.IDInstallation ORDER BY Cote ASC ";
        $SQL->select($Req);
        $Installations = array();
        while($installation_results_set = $SQL->FetchArray()){
            $Installations[] = new Installation($installation_results_set['IDInstallation']);
        }

        return $Installations;
    }

    static function get_installations_by_cote($cote){
        $SQL = new sqlclass;
        $Req = "SELECT installation.IDInstallation FROM installation WHERE `Cote`='".$cote."' ";
        $SQL->select($Req);
        $Installations = array();
        while($installation_results_set = $SQL->FetchArray()){
            $Installations[] = new Installation($installation_results_set['IDInstallation']);
        }

        return $Installations;
    }

    static function get_installation_by_customer_cote($customer_cote){
        $SQL = new sqlclass;
        $Req = "SELECT installation.IDInstallation from installation JOIN client on client.IDClient = installation.IDClient WHERE client.Cote='".$customer_cote."' ORDER BY installation.Cote ASC ";
        $SQL->select($Req);
        $Installations = array();
        while($installation_results_set = $SQL->FetchArray()){
            $Installations[] = new Installation($installation_results_set['IDInstallation']);
        }

        return $Installations;
    }


    static function get_installations_by_customer_id($customer_id){
        $SQL = new sqlclass;
        $Req = "SELECT installation.IDInstallation from installation JOIN client on client.IDClient = installation.IDClient WHERE client.IDClient='".$customer_id."' ORDER BY installation.Cote ASC ";
        $SQL->select($Req);
        $Installations = array();
        while($installation_results_set = $SQL->FetchArray()){
            $Installations[] = new Installation($installation_results_set['IDInstallation']);
        }

        return $Installations;
    }


    static function get_installations_to_bill_for_semaine($cote, $semaine){
        #Sans joke c'est vraiment a chier comme facon de checker si ya des shift 'a biller....
        $time_service = new TimeService();
        $start_of_week = $time_service->get_start_of_week($semaine);

        $SQL = new sqlclass;
        $Req = "SELECT installation.IDInstallation, sum(shift.Facture) as isBilled FROM shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE `Cote`='".$cote."' and semaine=".$start_of_week->getTimestamp()." GROUP BY installation.IDInstallation HAVING isBilled=0 ORDER BY Cote ASC ";
        $SQL->select($Req);
        $Installations = array();
        while($installation_results_set = $SQL->FetchArray()){
            $Installations[] = new Installation($installation_results_set['IDInstallation']);
        }

        return $Installations;
    }

}
