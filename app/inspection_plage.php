<?php
include_once('base_model.php');
class inspection_plage extends base_model
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
    public $Chaloupe;

    function select_all_query(){
        return "SELECT * FROM inspection WHERE IDInspection = ";
    }





}