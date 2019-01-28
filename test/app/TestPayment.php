<?php

include_once ('app/payment/payment.php');
include_once ('app/facture/facture.php');

class TestPayment extends PHPUnit_Framework_TestCase
{

    function test_givenPaymentWithOneFullyPaidFacture_whenGetPaidFacture_thenGetCorrectFacturePaid(){
        $payment = new Payment(104);
        $facture_paid = $payment->get_paid_facture();

        $this->assertEquals(1, count($facture_paid));
        $this->assertEquals(1353, array_pop($facture_paid)->IDFacture);
    }

    function test_givenPaymentWithPaidFacture_whenGetPaidFacture_thenGetCorrectFacturePaid(){
        $payment = new Payment(105);
        $facture_paid = $payment->get_paid_facture();

        $this->assertEquals(2, count($facture_paid));
        $this->assertEquals(1358, array_pop($facture_paid)->IDFacture);
        $this->assertEquals(1354, array_pop($facture_paid)->IDFacture);
    }

    function test_givenPartialPaymentWithOneFacture_whenGetPaymentBalance_thenGetPositiveAmount(){
        $payment = new Payment(106);
        $factures = array(
            "1355"=> new Facture(1355)
        );

        $unpaid_balance = $payment->get_payment_balance($factures);

        $this->assertEquals(144.93, $unpaid_balance,'',0.001);
    }

    function test_givenPartialPaymentWithTwoFacture_whenGetPaymentBalance_thenGetPositiveAmount(){
        $payment = new Payment(107);
        $factures = array(
            "1356"=> new Facture(1356),
            "1357"=> new Facture(1357)
        );

        $unpaid_balance = $payment->get_payment_balance($factures);

        $this->assertEquals(734.78, $unpaid_balance,'',0.001);
    }

    function test_givenFactureThatWasPaidByPayment_whenPaidFacture_thenReturnTrue(){
        $payment = new Payment(104);
        $facture = new facture(1353);

        $has_been_paid = $payment->paid_facture($facture);

        $this->assertTrue($has_been_paid);
    }
}
