<?php

include_once ('app/facture/factureInterest.php');
include_once ('app/facture/facture.php');
include_once ('app/payment/payment.php');

class TestFactureInterest extends PHPUnit_Framework_TestCase{
    function test_givenIDFactureOfInterestFacture_whenContruct_thenGetFactureInterest(){
        $facture = new FactureInterest(3015); #Facture Shift

        $this->assertTrue($facture->is_interest());
    }

    function test_givenIDFactureOfShiftFacture_whenIsShift_thenReturnFalse(){
        $facture = new FactureInterest(3015); #Facture Shift

        $this->assertFalse($facture->is_shift());
    }


    function test_whenGetTransactions_thenFactureInterestArePositiveDebit(){
        $facture = new FactureInterest(3015); #Facture Shift
        $this->assertEquals(400, $facture->get_customer_transaction()['debit'], 0,.001);
    }

}
