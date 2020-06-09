<?php

include_once('app/invoice/interestInvoice.php');
include_once('app/invoice/invoice.php');
include_once ('app/payment/payment.php');

class TestFactureInterest extends PHPUnit_Framework_TestCase{
    function test_givenIDFactureOfInterestFacture_whenContruct_thenGetFactureInterest(){
        $facture = new InterestInvoice(3015); #Facture Shift

        $this->assertTrue($facture->is_interest());
    }

    function test_givenIDFactureOfShiftFacture_whenIsShift_thenReturnFalse(){
        $facture = new InterestInvoice(3015); #Facture Shift

        $this->assertFalse($facture->is_shift());
    }


    function test_whenGetTransactions_thenFactureInterestArePositiveDebit(){
        $facture = new InterestInvoice(3015); #Facture Shift
        $this->assertEquals(400, $facture->get_customer_transaction()['debit'], 0,.001);
    }

}
