<?php

include_once ('app/payment.php');

class TestPayment extends PHPUnit_Framework_TestCase
{

    function test_givenPaymentWithOneFullyPaidFacture_whenGetPaidFacture_thenGetCorrectFacturePaid()
    {
        $payment = new Payment(104);
        $facture_paid = $payment->get_paid_facture();

        $this->assertEquals(1, count($facture_paid));
        $this->assertEquals(1353, array_pop($facture_paid)->IDFacture);
    }
}