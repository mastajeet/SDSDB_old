<?php

include_once ('app/facture/facture.php');
include_once ('app/payment.php');

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

    function test_givenRegularFacture_whenIsDebit_thenReturnTrue(){
        $facture = new Facture(1350); #Facture payee

        $this->assertEquals(true, $facture->is_debit());
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

    function test_givenPaidFactureAndPayments_whenGetPayment_thenGetPayment(){
        $facture = new Facture(1349);
        $payments = array(
            108=> new Payment(108),
            109=> new Payment(109)
        );

        $payment = $facture->get_payment($payments);

        $this->assertEquals(108,$payment->IDPaiement);
    }
}
