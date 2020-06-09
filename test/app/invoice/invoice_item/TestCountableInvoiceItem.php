<?php

include_once('app/invoice/invoice_item/countableInvoiceItem.php');
include_once ('app/payment/payment.php');

class TestCountableInvoiceItem extends PHPUnit_Framework_TestCase{

    const UNE_COTE = "TII";
    const UN_ID_DE_FACTURE_DE_MATERIEL = 4002;
    const UN_ID_DE_FACTSHEET_COMPTABLE = 5;

    function test_givenIDFactureDeMateriel_whenGetInvoiceItemFromInvoiceId_thenReturnArrayOfAssociatedCountableInvoiceItems(){
        $invoice_items = CountableInvoiceItem::find_item_by_invoice_id(self::UN_ID_DE_FACTURE_DE_MATERIEL);

        $this->assertEquals(2, count($invoice_items));
        $first_invoice_item = array_pop($invoice_items);
        $this->isInstanceOf(CountableInvoiceItem::class, $first_invoice_item);
    }

    function test_givenCountableInvoiceItemId_whenAddToBalance_ThenValueItemIsCalculted(){
        $invoice_item = new CountableInvoiceItem(self::UN_ID_DE_FACTSHEET_COMPTABLE);
        $balance = 0;
        $invoice_item->add_to_balance($balance);

        $this->assertEquals(300, $balance);
    }
}
