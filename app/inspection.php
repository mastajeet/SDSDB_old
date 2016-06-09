<?php
include_once('installation.php');
include_once('base_model.php');

class inspection extends base_model
{


    ## Info ###################
    public $IDInspection;
    public $IDEmploye;
    public $DateR;
    public $DateP;
    public $DateI;
    public $IDInstallation;
    public $Annee;
    public $IDResponsable;
    public $IDFacture;
    public $InspectionType;

    ## Materiel ##############

    # Shared #####
    public $Mirador;
    public $SMU;
    public $Procedures;
    public $Couverture;
    public $Registre;
    public $Bouees;

    # Piscine #####
    public $Perche;
    public $Planche;
    public $Chlore;

    # Plage #####

    public $Chaloupe;
    public $ChaloupeRame;
    public $ChaloupeAncre;
    public $ChaloupeGilets;
    public $ChaloupeBouee;
    public $LigneBouee;
    public $BoueeProfond;

    ## Affichage #################

    # Shared #####
    public $Verre;

    # Plage #####
    public $Canotage;
    public $HeureSurveillance;
    public $LimitePlage;

    # Piscine #####
    public $Bousculade;
    public $Maximum;
    public $ProfondeurPP;
    public $ProfondeurP;
    public $ProfondeurPente;
    public $Cercle;

    ## Construction ###########

    # Piscine #####
    public $EchellePP;
    public $EchelleX2P;
    public $Escalier;
    public $Cloture12;
    public $Cloture100;
    public $Maille38;
    public $Promenade;
    public $Fermeacle;

    # Plage #####
    public $LongueurPlage;

    ## Trousse ###############

    public $Manuel;
    public $Antiseptique;
    public $Epingle;
    public $Pansement;
    public $BTria;
    public $Gaze50;
    public $Gaze100;
    public $Ouate;
    public $Gaze75;
    public $Compressif;
    public $Tape12;
    public $Tape50;
    public $Eclisses;
    public $Ciseau;
    public $Pince;
    public $Crayon;
    public $Masque;
    public $Gant;
    public $Envoye;
    public $Confirme;
    public $Materiel;
    public $MaterielPret;
    public $MaterielLivre;
    public $Notes;
    public $NotesMateriel;
    public $NotesAffichage;
    public $NotesConstruction;

    function define_data_types(){
        $this->data_type = array(
        'IDInspection'=>'ID',
//        'IDEmploye'=>'int',
        'DateR'=>'int',
        'DateP'=>'int',
        'DateI'=>'int',
//        'IDInstallation'=>'int',
//        'Annee'=>'int',
//        'IDResponsable'=>'int',
//        'IDFacture'=>'int',
//
//        'Mirador'=>'int',
//        'SMU'=>'int',
//        'Procedures'=>'int',
//        'Couverture'=>'int',
//        'Registre'=>'int',
//        'Bouees'=>'int',
//
//        'Perche'=>'int',
//        'Planche'=>'int',
//        'Chlore'=>'int',
//
//        'Chaloupe'=>'int',
//        'ChaloupeRame'=>'int',
//        'ChaloupeAncre'=>'int',
//        'ChaloupeGilets'=>'int',
//        'ChaloupeBouee'=>'int',
//        'LigneBouee'=>'int',
//        'BoueeProfond'=>'int',
//
//        'Verre'=>'int',
//
//        'Canotage'=>'int',
//        'HeureSurveillance'=>'int',
//        'LimitePlage'=>'int',
//
//        'Bousculade'=>'int',
//        'Maximum'=>'int',
//        'ProfondeurPP'=>'int',
//        'ProfondeurP'=>'int',
//        'ProfondeurPente'=>'int',
//        'Cercle'=>'int',
//
//        'EchellePP'=>'int',
//        'EchelleX2P'=>'int',
//        'Escalier'=>'int',
//        'Cloture12'=>'int',
//        'Cloture100'=>'int',
//        'Maille38'=>'int',
//        'Promenade'=>'int',
//        'Fermeacle'=>'int',
//
//        'LongueurPlage'=>'int',
//
//        'Manuel'=>'int',
//        'Antiseptique'=>'int',
//        'Epingle'=>'int',
//        'Pansement'=>'int',
//        'BTria'=>'int',
//        'Gaze50'=>'int',
//        'Gaze100'=>'int',
//        'Ouate'=>'int',
//        'Gaze75'=>'int',
//        'Compressif'=>'int',
//        'Tape12'=>'int',
//        'Tape50'=>'int',
//        'Eclisses'=>'int',
//        'Ciseau'=>'int',
//        'Pince'=>'int',
//        'Crayon'=>'int',
//        'Masque'=>'int',
//        'Gant'=>'int',
//        'Envoye'=>'int',
//        'Confirme'=>'int',
//        'Materiel'=>'int',
//        'MaterielPret'=>'int',
//        'MaterielLivre'=>'int',
//        'Notes'=> 'string',
//        'NotesMateriel'=> 'string',
//        'NotesAffichage'=> 'string',
//        'NotesConstruction'=> 'string'
           );
    }

    function __construct($arg){
        parent::__construct($arg);
        $installation = new installation($this->IDInstallation);
        if($installation->IDType=="P"){
            $this->InspectionType = "Plage";
        }else{
            $this->InspectionType = "Piscine";
        }
    }

    function define_table_info(){
        $this->model_table = "inspection";
        $this->model_table_id = "IDInspection";
    }

    function save(){
        parent::save();
    }

}