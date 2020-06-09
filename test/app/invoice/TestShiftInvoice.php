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
        $facture = new ShiftInvoice(3010); #Facture Shift

        $this->assertEquals('TimedInvoiceItem',$facture->item_type);
    }

//    function test_givenShiftInvoiceWithInvoiceItems_whenGetItems_thenSetAndReturnInvoiceItems(){
//        $facture = new ShiftInvoice(3010); #Facture Shift
//
//        $this->assertEquals(count($facture->get_items()),3);
//    }

}
