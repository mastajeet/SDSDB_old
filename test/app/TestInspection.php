<?php

require_once('app/inspection.php');
require_once('mysql_class_test.php');

class TestInspection extends PHPUnit_Framework_TestCase
{
    function test_constructeur()
    {
        $inspection = new inspection(32);
        $this->assertEquals($inspection->IDInstallation, 58);
    }

    function test_inspection_type_piscine()
    {
        $inspection = new inspection(32);
        $this->assertEquals($inspection->InspectionType, "Piscine");
    }

    function test_inspection_type_plage(){
        $inspection = new inspection(32);
        $this->assertEquals($inspection->InspectionType,"Piscine");
    }


    function test_constructeur_2()
    {
        try {
            $inspection = new inspection(-5);
            $this->assertEquals(1, -1);
        } catch (Exception $e) {
            $this->assertEquals(1, 1);
        }
    }

    function test_generate_update_statement()
    {
        $inspection = new inspection(32);
        $this->assertEquals("UPDATE inspection SET IDEmploye=2, DateP=1244221200, DateI=1244178000, IDInstallation=58, Annee=2009, IDResponsable=67, IDFacture=3664, Mirador=1, SMU=1, Procedures=1, Perche=1, Bouees=1, Planche=1, Couverture=0, Registre=0, Chlore=0, ProfondeurPP=100, ProfondeurP=100, ProfondeurPente=100, Cercle=1, Verre=25, Bousculade=25, Maximum=150, EchellePP=1, EchelleX2P=1, Escalier=1, Cloture12=1, Cloture100=1, Maille38=1, Promenade=1, Fermeacle=1, Manuel=1, Antiseptique=20, Epingle=24, Pansement=10, BTria=5, Gaze50=2, Gaze100=2, Ouate=4, Gaze75=5, Compressif=0, Tape12=1, Tape50=1, Eclisses=0, Ciseau=0, Pince=0, Crayon=0, Masque=1, Gant=0, Envoye=1, Confirme=1, Materiel=1, MaterielPret=1, MaterielLivre=1, Chaloupe=0, ChaloupeRame=0, ChaloupeAncre=0, ChaloupeGilets=0, ChaloupeBouee=0, LigneBouee=0, BoueeProfond=0, Canotage=0, HeureSurveillance=0, LimitePlage=0, LongueurPlage=0 WHERE IDInspection = 32", $inspection->generate_update_statement());
    }

    function test_generate_insert_statement()
    {
        $inspection = new inspection(array('IDInstallation' => 25, 'DateR' => 12365478, 'Chaloupe' => '1', 'NotesConstruction' => 'okay'));
        $this->assertEquals("INSERT INTO inspection(`IDInstallation`, `DateR`, `Chaloupe`, `NotesConstruction`) VALUES (25, 12365478, 1, \"okay\")", $inspection->generate_insert_statement());
    }

}