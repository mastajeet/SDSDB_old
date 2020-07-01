<?php

include_once('app/invoice/InterestInvoice.php');
include_once('app/invoice/invoice.php');
include_once ('app/payment/payment.php');

class TestInterestInvoice extends PHPUnit_Framework_TestCase{
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

    function test_givenEquipmentInvoiceWithInvoiceItems_thenInvoiceItemsAreCountableCreditInvoiceItems()
    {
        $invoice = new InterestInvoice(4001); #Facture matériel avec invoice items
        $invoice_items = $invoice->get_items();

        $this->assertInstanceOf(CountableInvoiceItem::class, array_pop($invoice_items));
    }
}
