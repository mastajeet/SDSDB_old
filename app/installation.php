<?php
include_once('base_model.php');
class installation extends base_model
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

  function define_table_info(){
    $this->model_table = 'installation';
    $this->model_table_id = 'IDInstallation';
  }

  static function get_installations_to_bill($semaine){

      $SQL = new sqlclass;
      $Req = "SELECT Cote, sum(Facture) as isFactured FROM shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE `Semaine`=".$semaine." GROUP BY Cote HAVING isFactured=0 ORDER BY Cote ASC ";

      $SQL->select($Req);
      $Installation = array();
      while($Rep = $SQL->FetchArray()){
          $Installation[$Rep[0]] = get_installation_by_cote_in_string($Rep[0]);
      }
      $SQL->CloseConnection();
      return $Installation;

  }
}
