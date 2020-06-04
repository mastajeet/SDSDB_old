<?php

include_once ('app/facture/factureMateriel.php');
include_once ('app/facture/facture.php');
include_once ('app/payment/payment.php');

class TestFactureMateriel extends PHPUnit_Framework_TestCase{
    function test_givenIDFactureOfMaterielFacture_whenContruct_thenGetFactureMateriel(){
        $facture = new FactureMateriel(3011); #Facture Shift

        $this->assertEquals(2, $facture->Sequence);
    }

    function test_whenGetTransactions_thenFactureMaterielArePositiveDebit(){
        $facture = new FactureMateriel(3011); #Facture Shift
        $this->assertEquals(400*(1.095)*(1.05), $facture->get_customer_transaction()['debit'], 0,001);
    }

    function test_givenIDFactureOfShiftFacture_whenIsShift_thenReturnFalse(){
        $facture = new FactureMateriel(3011); #Facture Shift

        $this->assertFalse($facture->is_shift());
    }

    function test_givenIDFactureOfShiftFacture_whenIsMateriel_thenReturnTrue(){
        $facture = new FactureMateriel(3011); #Facture Shift

        $this->assertTrue($facture->is_materiel());
    }
}
