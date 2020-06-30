<?php
require_once('view/invoice/invoice_item/InvoiceItemFormFieldsRendererFactory.php');

class TestInvoiceItemFormFieldRendererFactory extends PHPUnit_Framework_TestCase
{

    private $invoice_item_form_field_renderer_factory;
    /**
     * @before
     */

    function buildContentArray(){
        $this->invoice_item_form_field_renderer_factory = new InvoiceItemFormFieldsRendererFactory(new TimeService());
    }

    function test_givenShiftInvoice_whenGetInsertInvoiceItemFormFieldRenderer_thenObtainTimedInvoiceFormFieldRenderer()
    {
        $invoice = new MonthlyInvoice(array(), null);
        $renderer = $this->invoice_item_form_field_renderer_factory->getInsertInvoiceItemFormFieldRenderer($invoice);

        $this->assertInstanceOf(TimedInvoiceItemFormFieldsRenderer::class, $renderer);
    }

    function test_givenShiftInvoice_whenGetUpdateInvoiceItemFormFieldRenderer_thenObtainTimedInvoiceFormFieldRenderer()
    {
        $invoice = new MonthlyInvoice(array(), null);
        $renderer = $this->invoice_item_form_field_renderer_factory->getUpdateInvoiceItemFormFieldRenderer($invoice);

        $this->assertInstanceOf(TimedInvoiceItemFormFieldsRenderer::class, $renderer);
    }
}
