<?php

include_once('app/invoice/Credit.php');
include_once('app/invoice/invoice.php');

class TestCredit extends PHPUnit_Framework_TestCase{

    function test_givenIDFactureOfShiftFacture_whenContruct_thenGetFactureValues(){
        $facture = new Credit(3012); #Facture Shift

        $this->assertEquals(3, $facture->Sequence);
    }

    function test_givenCredit_whenGetCustomerTransaction_thenGetTransactionDetail(){
        $facture = new Credit(3012); #Facture matériel
        $transaction_details = $facture->get_customer_transaction();
        $expected_notes = "Crédit TFF-3";
        $this->assertEquals($expected_notes, $transaction_details['notes']);
    }

    function test_whenGetTransactions_thenCreditAreNegativeDebit(){
        $credit = new Credit(3012); #Facture matériel
        $this->assertEquals(-400*(1.095)*(1.05), $credit->get_customer_transaction()['debit'], 0,001);  // Première transaction (crédit)
    }

    function test_givenCreditWithInvoiceItems_thenInvoiceItemsAreCountableCreditInvoiceItems()
    {
        $credit = new Credit(1347);
        $invoice_items = $credit->get_items();

        $this->assertInstanceOf(CountableCreditedInvoiceItem::class, array_pop($invoice_items));
    }

}
