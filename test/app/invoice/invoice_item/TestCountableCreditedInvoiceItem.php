<?php

include_once('app/invoice/invoice_item/CountableInvoiceItem.php');
include_once ('app/payment/payment.php');

class TestCountableCreditedInvoiceItem extends PHPUnit_Framework_TestCase{

    const UNE_COTE = "TII";
    const UN_ID_DE_CREDIT = 1347;
    const UN_ID_DE_INVOICE_ITEM_CREDITE = 8;

    function test_givenIDFactureDeMateriel_whenGetInvoiceItemFromInvoiceId_thenReturnArrayOfAssociatedCountableInvoiceItems(){
        $invoice_items = CountableCreditedInvoiceItem::findItemByInvoiceId(self::UN_ID_DE_CREDIT);

        $this->assertEquals(1, count($invoice_items));
        $first_invoice_item = array_pop($invoice_items);
        $this->isInstanceOf(CountableCreditedInvoiceItem::class, $first_invoice_item);
    }

    function test_givenCountableInvoiceItemId_whenAddToBalance_ThenValueItemIsCalculted(){
        $invoice_item = new CountableCreditedInvoiceItem(self::UN_ID_DE_INVOICE_ITEM_CREDITE);
        $balance = 0;
        $invoice_item->add_to_balance($balance);

        $this->assertEquals(-400, $balance);
    }

    function test_givenCountableInvoiceItemId_whenGetNumberBilledItem_thenGetDifferenceOfItems()
    {
        $invoice_item = new CountableCreditedInvoiceItem(self::UN_ID_DE_INVOICE_ITEM_CREDITE);

        $number_of_billed_items = $invoice_item->getNumberOfBilledItems();

        $this->assertEquals(1, $number_of_billed_items);
    }

    function test_givenCountableItemWithAmountBilledIsZero_whenIsEmpty_thenReturnTrue()
    {
        $invoice_item = CountableCreditedInvoiceItem::fromDetails(array("quantity"=>0,'unit_cost'=>1));

        $this->assertTrue($invoice_item->isEmpty());
    }

    function test_givenCountableItemWithAmountBilledIsNotZero_whenIsEmpty_thenReturnFalse()
    {
        $invoice_item = CountableCreditedInvoiceItem::fromDetails(array("quantity"=>1,'unit_cost'=>1));

        $this->assertFalse($invoice_item->isEmpty());
    }
}
