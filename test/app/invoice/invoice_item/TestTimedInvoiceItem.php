<?php

include_once('app/invoice/invoice_item/TimedInvoiceItem.php');
include_once ('app/payment/payment.php');

class TestTimedInvoiceItem extends PHPUnit_Framework_TestCase{

    const UNE_COTE = "TII";
    const UN_ID_DE_FACTURE_DE_TEMPS = 4001;
    const UN_ID_DE_FACTSHEET_DE_TEMPS = 1;

    function test_givenIDFactureDeTemps_whenGetInvoiceItemFromInvoiceId_thenReturnArrayOfAssociatedTimedInvoiceItems(){
        $invoice_items = TimedInvoiceItem::findItemByInvoiceId(self::UN_ID_DE_FACTURE_DE_TEMPS);

        $this->assertEquals(3, count($invoice_items));
        $first_invoice_item = array_pop($invoice_items);
        $this->assertInstanceOf(TimedInvoiceItem::class, $first_invoice_item);
    }

    function test_givenIimedInvoiceItemId_whenAddToBalance_ThenValuePerHourIsCalculted(){
        $invoice_item = new TimedInvoiceItem(self::UN_ID_DE_FACTSHEET_DE_TEMPS);
        $balance = 0;
        $invoice_item->add_to_balance($balance);

        $this->assertEquals(150, $balance);
    }

    function test_givenTimedInvoiceItem_whenGetNumberOfBilledItems_thenCountAmountOfHours(){
        $invoice_item = new TimedInvoiceItem(self::UN_ID_DE_FACTSHEET_DE_TEMPS);

        $number_of_billed_hours = $invoice_item->getNumberOfBilledItems();

        $this->assertEquals(3, $number_of_billed_hours);
    }

    function test_givenShiftItemWithAmountBilledIsZero_whenIsEmpty_thenReturnTrue()
    {
        $invoice_item = TimedInvoiceItem::fromDetails(array("start"=>'',"end"=>0,"hourly_rate"=>1));

        $this->assertTrue($invoice_item->isEmpty());
    }

    function test_givenCountableItemWithAmountBilledNotZero_whenIsEmpty_thenReturnFalse()
    {
        $invoice_item = TimedInvoiceItem::fromDetails(array("start"=>0,"end"=>4,"hourly_rate"=>1));

        $this->assertFalse($invoice_item->isEmpty());
    }
}
