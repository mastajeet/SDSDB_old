<?php

include_once('app/invoice/invoice_item/timedInvoiceItem.php');
include_once ('app/payment/payment.php');

class TestTimedInvoiceItem extends PHPUnit_Framework_TestCase{

    const UNE_COTE = "TII";
    const UN_ID_DE_FACTURE_DE_TEMPS = 4001;
    const UN_ID_DE_FACTSHEET_DE_TEMPS = 1;

    function test_givenIDFactureDeTemps_whenGetInvoiceItemFromInvoiceId_thenReturnArrayOfAssociatedTimedInvoiceItems(){
        $invoice_items = TimedInvoiceItem::find_item_by_invoice_id(self::UN_ID_DE_FACTURE_DE_TEMPS);

        $this->assertEquals(3, count($invoice_items));
        $first_invoice_item = array_pop($invoice_items);
        $this->isInstanceOf(TimedInvoiceItem::class, $first_invoice_item);
    }

    function test_givenIimedInvoiceItemId_whenAddToBalance_ThenValuePerHourIsCalculted(){
        $invoice_item = new TimedInvoiceItem(self::UN_ID_DE_FACTSHEET_DE_TEMPS);
        $balance = 0;
        $invoice_item->add_bill_item_to_balance($balance);

        $this->assertEquals(150, $balance);
    }
}
