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
        $invoice = InvoiceFactory::getTypedInvoice(new Invoice($invoice_id));
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

    function getUpdateInvoiceItemFormFieldRenderer($invoice_id) #Les formulaire d'édition seront différents des formulaire d'insertion pour les factures de matériel
    {
        $invoice = InvoiceFactory::getTypedInvoice(new Invoice($invoice_id));
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
