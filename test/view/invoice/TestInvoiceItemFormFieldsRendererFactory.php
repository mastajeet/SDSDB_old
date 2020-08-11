<?php
require_once('view/invoice/invoice_item/InvoiceItemFormFieldsRendererFactory.php');
require_once('helper/ItemService.php');


class TestInvoiceItemFormFieldRendererFactory extends PHPUnit_Framework_TestCase
{
    const A_WEEKLY_SHIFT_INVOICE_ID = 1337;
    const A_MONTHLY_SHIFT_INVOICE_ID = 1336;
    const AN_EQUIPMENT_INVOICE_ID = 1359;
    const A_CREDIT_ID = 1347;
    private $invoice_item_form_field_renderer_factory;
    /**
     * @before
     */

    function buildContentArray(){
        $this->invoice_item_form_field_renderer_factory = new InvoiceItemFormFieldsRendererFactory(new TimeService(), new ItemService());
    }

    function test_givenMonthlyInvoiceId_whenGetInsertInvoiceItemFormFieldRenderer_thenObtainTimedInvoiceFormFieldRenderer()
    {
        $renderer = $this->invoice_item_form_field_renderer_factory->getInsertInvoiceItemFormFieldRenderer(self::A_MONTHLY_SHIFT_INVOICE_ID);

        $this->assertInstanceOf(TimedInvoiceItemFormFieldsRenderer::class, $renderer);
    }

    function test_givenWeeklyInvoiceId_whenGetUpdateInvoiceItemFormFieldRenderer_thenObtainTimedInvoiceFormFieldRenderer()
    {

        $renderer = $this->invoice_item_form_field_renderer_factory->getUpdateInvoiceItemFormFieldRenderer(self::A_WEEKLY_SHIFT_INVOICE_ID);

        $this->assertInstanceOf(TimedInvoiceItemFormFieldsRenderer::class, $renderer);
    }

    function test_givenEquipmentInvoiceId_whenGetInsertInvoiceItemFormFieldRenderer_thenObtainEquipmentInvoiceItemFormFieldRenderer()
    {
        $renderer = $this->invoice_item_form_field_renderer_factory->getInsertInvoiceItemFormFieldRenderer(self::AN_EQUIPMENT_INVOICE_ID);

        $this->assertInstanceOf(EquipmentInvoiceItemFormFieldsRenderer::class, $renderer);
    }

    function test_givenEquipementInvoiceId_whenGetUpdateInvoiceItemFormFieldRenderer_thenObtainCountableInvoiceItemFormFieldRenderer()
    {
        $renderer = $this->invoice_item_form_field_renderer_factory->getUpdateInvoiceItemFormFieldRenderer(self::AN_EQUIPMENT_INVOICE_ID);

        $this->assertInstanceOf(CountableInvoiceItemFormFieldsRenderer::class, $renderer);
    }

    function test_givenCreditId_whenGetInsertInvoiceItemFormFieldRenderer_thenObtainCountableInvoiceItemFormFieldRenderer()
    {
        $renderer = $this->invoice_item_form_field_renderer_factory->getInsertInvoiceItemFormFieldRenderer(self::A_CREDIT_ID);

        $this->assertInstanceOf(CountableInvoiceItemFormFieldsRenderer::class, $renderer);
    }

    function test_givenCreditId_whenGetUpdateInvoiceItemFormFieldRenderer_thenObtainCountableInvoiceItemFormFieldRenderer()
    {
        $renderer = $this->invoice_item_form_field_renderer_factory->getUpdateInvoiceItemFormFieldRenderer(self::A_CREDIT_ID);

        $this->assertInstanceOf(CountableInvoiceItemFormFieldsRenderer::class, $renderer);
    }
}
