<?php

include_once ('app/facture/factureShift.php');
include_once ('app/facture/facture.php');
include_once ('app/payment/payment.php');

class TestFactureShift extends PHPUnit_Framework_TestCase{

    function test_givenIDFactureOfShiftFacture_whenContruct_thenGetFactureValues(){
        $facture = new FactureShift(3010); #Facture Shift

        $this->assertEquals(1, $facture->Sequence);
    }
}
