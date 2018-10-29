<?php

include_once ('app/facture/facture.php');

class TestFacture extends PHPUnit_Framework_TestCase{

    const UNE_COTE = "TF";
    const UN_NUMERO_SEQUENTIEL = "1";

    function test_givenPaidFacture_whenIsPaid_thenReturnTrue(){
        $facture = new Facture(1349); #Facture payee

        $this->assertEquals(true, $facture->is_paid());
    }

    function test_givenUnpaidFacture_whenIsPaid_thenReturnFalse(){
        $facture = new Facture(1350); #Facture payee

        $this->assertEquals(false, $facture->is_paid());
    }

    function test_givenRegularFacture_whenIsCredit_thenReturnFalse(){
        $facture = new Facture(1350); #Facture payee

        $this->assertEquals(false, $facture->is_credit());
    }

    function test_givenCredit_whenIsCredit_thenReturnTrue(){
        $facture = new Facture(1351); #Facture payee

        $this->assertEquals(true, $facture->is_credit());
    }

    function test_givenFactureMateriel_whenIsMateriel_thenReturnTrue(){
        $facture = new Facture(1352); #Facture payee

        $this->assertEquals(true, $facture->is_materiel());
    }

    function test_givenRegularFacture_whenIsMateriel_thenReturnFalse(){
        $facture = new Facture(1351); #Facture payee

        $this->assertEquals(false, $facture->is_materiel());
    }

    function test_givenCorrectCoteAndSequence_whenGetByCoteAndSequence_thenGetCorrectFacture(){
        $facture = Facture::get_by_cote_and_sequence(self::UNE_COTE, self::UN_NUMERO_SEQUENTIEL);

        $this->assertEquals(1349, $facture->IDFacture);
    }
}