<?php

include_once('app/invoice/equipmentInvoice.php');
include_once('app/invoice/invoice.php');
include_once ('app/payment/payment.php');

class TestEquipmentInvoice extends PHPUnit_Framework_TestCase{

    const INVOICE_ID_WITH_WRONG_BALANCE = 1360;

    function test_givenIDFactureOfMaterielFacture_whenContruct_thenGetFactureMateriel(){
        $facture = new EquipmentInvoice(3011); #Facture Shift

        $this->assertEquals(2, $facture->Sequence);
    }

    function test_whenGetTransactions_thenFactureMaterielArePositiveDebit(){
        $facture = new EquipmentInvoice(3011); #Facture Shift
        $this->assertEquals(400*(1.095)*(1.05), $facture->get_customer_transaction()['debit'], 0,001);
    }

    function test_givenIDFactureOfShiftFacture_whenIsShift_thenReturnFalse(){
        $facture = new EquipmentInvoice(3011); #Facture Shift

        $this->assertFalse($facture->is_shift());
    }

    function test_givenIDFactureOfShiftFacture_whenIsMateriel_thenReturnTrue(){
        $facture = new EquipmentInvoice(3011); #Facture Shift

        $this->assertTrue($facture->is_materiel());
    }

    function test_givenEquipmentInvoiceIdWithIncorrectBalance_whenUpdate_thenUpdateWithInvoiceItemsValue(){
        $invoice = new EquipmentInvoice(self::INVOICE_ID_WITH_WRONG_BALANCE);
        $this->assertEquals(0, $invoice->STotal);

        $invoice->update_balance();
        $this->assertEquals(510, $invoice->STotal);
    }

    function test_givenShiftInvoiceWithInvoiceItems_whenGetItems_thenSetAndReturnTimeInvoiceItems(){
        $facture = new EquipmentInvoice(self::INVOICE_ID_WITH_WRONG_BALANCE); #Facture Shift
        $invoice_items = $facture->get_items();
        $this->assertEquals(count($invoice_items),2);
        $this->assertInstanceOf('CountableInvoiceItem',array_pop($invoice_items));
    }


}
