<?php

include_once('helper/InvoiceItemConverter.php');

class TestInvoiceItemConverter extends PHPUnit_Framework_TestCase{

    const A_QUANTITY = 10;
    const AN_ITEM_ID = 1;
    const AN_EQUIPMENT_INVOICE_ID = 1359;
    const A_SHIFT_INVOICE_ID = 1349;
    const A_CREDIT_ID = 1347;

    const A_START = 12;
    const AN_END = 15.5;
    const A_HOURLY_RATE = 13.90;
    const A_DAY = 3;
    const A_NOTE = "une_note";

    const A_PRICE = 1337;
    const A_DESCRIPTION = "une_description";


    function test_givingRequestDataForEquipmentInvoiceWithItemId_whenfromRequestDataToDTO_thenObtainDtoOfEquipmentInvoiceWithItemValues(){

        $request_data = array(
            "item_id"=>self::AN_ITEM_ID,
            "description"=>"",
            "quantity"=>self::A_QUANTITY,
            "unit_cost"=>"",
            "invoice_id"=> self::AN_EQUIPMENT_INVOICE_ID
        );

        $invoice_item_dto = InvoiceItemConverter::fromRequestDataToDTO($request_data);

        $expected_dto = array(
            "description" => "Manuel de secourisme",
            "unit_cost" => 7.3,
            "quantity" => 10,
            "invoice_id" => 1359
        );

        $this->assertEquals($expected_dto, $invoice_item_dto);
    }

    function test_givingRequestDataForEquipmentInvoiceWithItemIdWithOverridePrice_whenfromRequestDataToDTO_thenObtainDtoOfEquipmentInvoiceWithItemValuesWithOverridePrice(){

        $request_data = array(
            "item_id"=>self::AN_ITEM_ID,
            "description"=>"",
            "quantity"=>self::A_QUANTITY,
            "unit_cost"=>self::A_PRICE,
            "invoice_id"=> self::AN_EQUIPMENT_INVOICE_ID
        );

        $invoice_item_dto = InvoiceItemConverter::fromRequestDataToDTO($request_data);

        $expected_dto = array(
            "description" => "Manuel de secourisme",
            "unit_cost" => 1337,
            "quantity" => 10,
            "invoice_id" => 1359
        );

        $this->assertEquals($expected_dto, $invoice_item_dto);
    }

    function test_givingRequestDataForEquipmentInvoiceWithItemIdWithOverrideDescription_whenfromRequestDataToDTO_thenObtainDtoOfEquipmentInvoiceWithItemValuesWithOverrideDescription(){

        $request_data = array(
            "item_id"=>self::AN_ITEM_ID,
            "description"=>self::A_DESCRIPTION,
            "quantity"=>self::A_QUANTITY,
            "unit_cost"=>"",
            "invoice_id"=> self::AN_EQUIPMENT_INVOICE_ID
        );

        $invoice_item_dto = InvoiceItemConverter::fromRequestDataToDTO($request_data);

        $expected_dto = array(
            "description" => "une_description",
            "unit_cost" => 7.3,
            "quantity" => 10,
            "invoice_id" => 1359
        );

        $this->assertEquals($expected_dto, $invoice_item_dto);
    }

    function test_givingRequestDataForEquipmentInvoice_whenfromRequestDataToDTO_thenObtainDtoOfEquipmentInvoice(){

        $request_data = array(
            "item_id"=>"",
            "description"=>self::A_DESCRIPTION,
            "quantity"=>self::A_QUANTITY,
            "unit_cost"=>self::A_PRICE,
            "invoice_id"=> self::AN_EQUIPMENT_INVOICE_ID
        );

        $invoice_item_dto = InvoiceItemConverter::fromRequestDataToDTO($request_data);

        $expected_dto = array(
            "description" => "une_description",
            "unit_cost" => 1337,
            "quantity" => 10,
            "invoice_id" => 1359
        );

        $this->assertEquals($expected_dto, $invoice_item_dto);
    }

    function test_givingRequestDataForShiftInvoice_whenfromRequestDataToDTO_thenObtainDtoOfShiftInvoice(){

        $request_data = array(
            "day"=>self::A_DAY,
            "start"=>self::A_START,
            "end"=>self::AN_END,
            "hourly_rate"=>self::A_PRICE,
            "notes"=>self::A_NOTE,
            "invoice_id"=> self::A_SHIFT_INVOICE_ID,
        );

        $invoice_item_dto = InvoiceItemConverter::fromRequestDataToDTO($request_data);

        $expected_dto = Array (
            'invoice_id' => 1349,
            'day' => 3,
            'start' => 12,
            'end' => 15.5,
            'notes' => 'une_note',
            'hourly_rate' => 1337,
        );

        $this->assertEquals($expected_dto, $invoice_item_dto);
    }

    function test_givingRequestDataForCredit_whenfromRequestDataToDTO_thenObtainDtoOfCredit(){

        $request_data = array(
            "description"=>self::A_DESCRIPTION,
            "quantity"=>self::A_QUANTITY,
            "unit_cost"=>self::A_PRICE,
            "invoice_id"=> self::A_CREDIT_ID
        );

        $invoice_item_dto = InvoiceItemConverter::fromRequestDataToDTO($request_data);

        $expected_dto = array(
            "description" => "une_description",
            "unit_cost" => 1337,
            "quantity" => 10,
            "invoice_id" => 1347
        );


        $this->assertEquals($expected_dto, $invoice_item_dto);
    }
}
