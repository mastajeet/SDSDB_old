<?php

include_once('app/invoice/shiftInvoice.php');
include_once('app/invoice/invoice.php');
include_once ('app/payment/payment.php');

class TestShiftInvoice extends PHPUnit_Framework_TestCase{

    function test_givenIDFactureOfShiftFacture_whenContruct_thenGetFactureValues(){
        $facture = new ShiftInvoice(3010); #Facture Shift

        $this->assertEquals(1, $facture->Sequence);
    }

    function test_givenIDFactureOfShiftFacture_whenIsShiftFacture_thenReturnTrue(){
        $facture = new ShiftInvoice(3010); #Facture Shift

        $this->assertTrue($facture->is_shift());
    }

    function test_givenShiftInvoice_whenConstruct_thenInvoiceItemsAreTimedItems(){
        $facture = new ShiftInvoice(4001); #Facture Shift
        $items = $facture->get_items();
        $this->isInstanceOf('TimedInvoiceItem',array_pop($items));
    }

    function test_givenShiftInvoiceWithInvoiceItems_whenGetItems_thenSetAndReturnTimeInvoiceItems(){
        $facture = new ShiftInvoice(4001); #Facture Shift
        $invoice_items = $facture->get_items();
        $this->assertEquals(count($invoice_items),3);
        $this->assertInstanceOf('TimedInvoiceItem',array_pop($invoice_items));
    }

    function test_givenShiftInvoiceWithMultipleItems_whenGetInvoiceItemSummary_thenReturnNumberOfBilledHours(){
        $invoice = new ShiftInvoice(4001);

        $invoice_item_summary = $invoice->getInvoiceItemsSummary();
        $number_of_billed_hours = $invoice_item_summary['number_of_billed_items'];

        $this->assertEquals(22, $number_of_billed_hours);
    }

    function test_givenEquipmentInvoiceWithInvoiceItems_thenInvoiceItemsAreCountableCreditInvoiceItems()
    {
        $invoice = new ShiftInvoice(4001); #Facture matériel avec invoice items
        $invoice_items = $invoice->get_items();

        $this->assertInstanceOf(TimedInvoiceItem::class, array_pop($invoice_items));
    }
}
