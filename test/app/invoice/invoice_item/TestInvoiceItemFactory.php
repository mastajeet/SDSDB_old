<?php

include_once('app/invoice/invoice_item/CountableInvoiceItem.php');
include_once('app/invoice/invoice_item/CountableCreditedInvoiceItem.php');
include_once('app/invoice/invoice_item/TimedInvoiceItem.php');
include_once('app/invoice/invoice_item/InvoiceItemFactory.php');

class TestInvoiceItemFactory extends PHPUnit_Framework_TestCase{

    private $invoice_item_factory;
    private $timed_invoice_item_dto;
    const UN_ID = 12;
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

        $this->assertInstanceOf(CountableCreditedInvoiceItem::class, $invoice_item);
    }

    function test_givenShiftInvoiceAndDTO_whenGetTypedInvoiceItemFromDTO_thenObtainTimedInvoiceItem(){
        $shift_invoice = new ShiftInvoice(array());

        $invoice_item = $this->invoice_item_factory->getTypedInvoiceItemFromDTO($this->timed_invoice_item_dto, $shift_invoice);

        $this->assertInstanceOf(TimedInvoiceItem::class, $invoice_item);
    }

    function test_givenEquipmentInvoiceAndDTO_whenGetTypedInvoiceItemFromDTO_thenObtainCountableInvoiceItem(){
        $equipement_invoice = new EquipmentInvoice(array());

        $invoice_item = $this->invoice_item_factory->getTypedInvoiceItemFromDTO($this->timed_invoice_item_dto, $equipement_invoice);

        $this->assertInstanceOf(CountableInvoiceItem::class, $invoice_item);
    }

    function test_givenCreditAndDTO_whenGetTypedInvoiceItemFromDTO_thenObtainCountableCreditedInvoiceItem(){
        $credit = new Credit(array());

        $invoice_item = $this->invoice_item_factory->getTypedInvoiceItemFromDTO($this->timed_invoice_item_dto, $credit);

        $this->assertInstanceOf(CountableCreditedInvoiceItem::class, $invoice_item);
    }

    function test_givenInvoiceItemFromDTOWithModelId_whenSave_thenUpdate()
    {
        $equipement_invoice = new EquipmentInvoice(array());
        $invoice_item = $this->invoice_item_factory->getTypedInvoiceItemFromDTO(array("invoice_item_id"=>self::UN_ID), $equipement_invoice);

        $model_table_values = $invoice_item->define_table_info();
        $model_table_id = $model_table_values["model_table_id"];

        $this->assertFalse($invoice_item->$model_table_id == 0);
    }
}
