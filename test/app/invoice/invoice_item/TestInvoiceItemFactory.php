<?php

include_once('app/invoice/invoice_item/CountableInvoiceItem.php');
include_once('app/invoice/invoice_item/TimedInvoiceItem.php');
include_once('app/invoice/invoice_item/InvoiceItemFactory.php');

class TestInvoiceItemFactory extends PHPUnit_Framework_TestCase{

    private $invoice_item_factory;
    /**
     * @before
     */
    function buildContentArray(){
        $this->invoice_item_factory = new InvoiceItemFactory();
    }

    function test_givenShiftInvoice_whenGetTypedInvoiceItem_thenReturnTimedInvoiceItem(){
        $shift_invoice = new ShiftInvoice(array());

        $invoice_item = $this->invoice_item_factory->getTypedInvoiceItem(array(), $shift_invoice);

        $this->assertInstanceOf(TimedInvoiceItem::class, $invoice_item);
    }

    function test_givenEquipmentInvoice_whenGetTypedInvoiceItem_thenReturnCountableInvoiceItem(){
        $shift_invoice = new EquipmentInvoice(array());

        $invoice_item = $this->invoice_item_factory->getTypedInvoiceItem(array(), $shift_invoice);

        $this->assertInstanceOf(CountableInvoiceItem::class, $invoice_item);
    }

    function test_givenCredit_whenGetTypedInvoiceItem_thenReturnCountableInvoiceItem(){
        $shift_invoice = new Credit(array());

        $invoice_item = $this->invoice_item_factory->getTypedInvoiceItem(array(), $shift_invoice);

        $this->assertInstanceOf(CountableInvoiceItem::class, $invoice_item);
    }

}
