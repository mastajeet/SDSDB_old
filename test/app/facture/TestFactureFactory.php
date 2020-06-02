<?php

include_once ('app/facture/factureFactory.php');
include_once ('app/facture/facture.php');

include_once ('app/facture/factureShift.php');
include_once ('app/facture/factureMateriel.php');
include_once ('app/facture/Credit.php');
include_once ('app/facture/avanceClient.php');

class TestFactureFactory extends PHPUnit_Framework_TestCase{

    private $facture_factory;

    /**
     * @before
     */
    function setUp(){
        $this->facture_factory = new FactureFactory();
    }

    function test_givenFactureOfShift_whenGetTypedFacture_thenGetShiftFactureObject(){
        $facture = new Facture(3010);
        $shift_facture = $this->facture_factory->create_typed_facture($facture);

        $this->assertEquals(FactureShift::class, get_class($shift_facture));
        $this->assertEquals($shift_facture->Sequence, 1);
    }

    function test_givenFactureOfMateriel_whenGetTypedFacture_thenGetFactureMaterielObject(){
        $facture = new Facture(3011);
        $facture_materiel = $this->facture_factory->create_typed_facture($facture);

        $this->assertEquals(FactureMateriel::class, get_class($facture_materiel));
    }

    function test_givenFactureCredit_whenGetTypedFacture_thenGetCreditObject(){
        $facture = new Facture(3012);
        $credit = $this->facture_factory->create_typed_facture($facture);

        $this->assertEquals(Credit::class, get_class($credit));
    }

    function test_givenFactureOfAvanceClient_whenGetTypedFacture_thenGetAvanceClientObject(){
        $facture = new Facture(3013);
        $avance_client = $this->facture_factory->create_typed_facture($facture);

        $this->assertEquals(AvanceClient::class, get_class($avance_client));
    }

}
