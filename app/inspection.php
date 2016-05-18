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

    function select_all_query(){
        return "SELECT * FROM inspection WHERE IDInspection = ";
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


}