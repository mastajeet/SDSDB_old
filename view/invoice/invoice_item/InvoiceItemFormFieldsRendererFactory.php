<?php
include_once('view/invoice/invoice_item/TimedInvoiceItemFormFieldsRenderer.php');

class InvoiceItemFormFieldsRendererFactory
{
    private $time_service;

    function __construct(TimeService $time_service)
    {
        $this->time_service = $time_service;
    }

    function getInsertInvoiceItemFormFieldRenderer($invoice_id)
    {
        $invoice = InvoiceFactory::create_typed_invoice(new Invoice($invoice_id));
        if ($invoice instanceof ShiftInvoice)
        {
            // Need to handle monthly invoice, however current app does not. No regression here
            $day_array = $this->time_service->getNumberedDayOfWeekArray();
            $renderer = new TimedInvoiceItemFormFieldsRenderer($day_array);
        } else {
            // à faire
        }
        return $renderer;
    }
}
