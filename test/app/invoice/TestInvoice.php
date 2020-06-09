<?php

include_once('app/invoice/invoice.php');
include_once('app/invoice/invoice.php');
include_once ('app/payment/payment.php');

class TestInvoice extends PHPUnit_Framework_TestCase{

    const UNE_COTE = "TF";
    const UN_NUMERO_SEQUENTIEL = "1";

    function test_givenPaidFacture_whenIsPaid_thenReturnTrue(){
        $facture = new Invoice(1349); #Facture payee

        $this->assertEquals(true, $facture->is_paid());
    }

    function test_givenUnpaidFacture_whenIsPaid_thenReturnFalse(){
        $facture = new Invoice(1350); #Facture payee

        $this->assertEquals(false, $facture->is_paid());
    }

    function test_givenRegularFacture_whenIsCredit_thenReturnFalse(){
        $facture = new Invoice(1350); #Facture payee

        $this->assertEquals(false, $facture->is_credit());
    }

    function test_givenRegularFacture_whenIsDebit_thenReturnTrue(){
        $facture = new Invoice(1350); #Facture payee

        $this->assertEquals(true, $facture->is_debit());
    }

    function test_givenCredit_whenIsCredit_thenReturnTrue(){
        $facture = new Invoice(1351); #Facture payee

        $this->assertEquals(true, $facture->is_credit());
    }

    function test_givenFactureMateriel_whenIsMateriel_thenReturnTrue(){
        $facture = new Invoice(1359 ); #Facture payee

        $this->assertEquals(true, $facture->is_materiel());
    }

    function test_givenRegularFacture_whenIsMateriel_thenReturnFalse(){
        $facture = new Invoice(1351); #Facture payee

        $this->assertEquals(false, $facture->is_materiel());
    }

    function test_givenPaidFactureAndPayments_whenGetPayment_thenGetPayment(){
        $facture = new Invoice(1349);
        $payments = array(
            108=> new Payment(308),
            109=> new Payment(309)
        );

        $payment = $facture->get_payment($payments);

        $this->assertEquals(308,$payment->IDPaiement);
    }

    function test_givenFactureTemps_whenGetCustomerTransaction_thenGetTransactionDetail(){
        $facture = new Invoice(1349); #Facture payee
        $transaction_details = $facture->get_customer_transaction();
        $expected_date = new DateTime("@"."1530627972");
        $expected_notes = "TF-1";
        $this->assertEquals(400*(1.095)*(1.05), $transaction_details['debit'], 0.01);
        $this->assertEquals(0, $transaction_details['credit'], 0.01);
        $this->assertEquals($expected_date, $transaction_details['date']);
        $this->assertEquals($expected_notes, $transaction_details['notes']);
    }

    function test_givenFactureMateriel_whenGetCustomerTransaction_thenGetTransactionDetail(){
        $facture = new Invoice(1359); #Facture matériel
        $transaction_details = $facture->get_customer_transaction();
        $expected_notes = "TF-4 (Matériel)";
        $this->assertEquals($expected_notes, $transaction_details['notes']);
    }


}
