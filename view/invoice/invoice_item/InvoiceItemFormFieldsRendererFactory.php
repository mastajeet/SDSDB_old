<?php
include_once('view/invoice/invoice_item/TimedInvoiceItemFormFieldsRenderer.php');
include_once('view/invoice/invoice_item/EquipmentInvoiceItemFormFieldsRenderer.php');
include_once('view/invoice/invoice_item/CountableInvoiceItemFormFieldsRenderer.php');

class InvoiceItemFormFieldsRendererFactory
{
    private $time_service;
    private $item_service;

    function __construct(TimeService $time_service, ItemService $item_service)
    {
        $this->time_service = $time_service;
        $this->item_service = $item_service;
    }

    function getInsertInvoiceItemFormFieldRenderer($invoice_id)
    {
        $invoice = InvoiceFactory::getTypedInvoice(new Invoice($invoice_id));
        if ($invoice instanceof ShiftInvoice)
        {
            // Need to handle monthly invoice, however current app does not. No regression here
            $day_array = $this->time_service->getNumberedDayOfWeekArray();
            $renderer = new TimedInvoiceItemFormFieldsRenderer($day_array);
        } else if($invoice instanceof EquipmentInvoice) { #We are using a special form to automate the item selection (from the DB)
            $item_array = $this->item_service->getIndexedActiveItemDescriptionsList();
            $renderer = new EquipmentInvoiceItemFormFieldsRenderer($item_array);
        } else {
            $renderer = new CountableInvoiceItemFormFieldsRenderer();
        }
        return $renderer;
    }

    function getUpdateInvoiceItemFormFieldRenderer($invoice_id)
    {
        $invoice = InvoiceFactory::getTypedInvoice(new Invoice($invoice_id));
        if ($invoice instanceof ShiftInvoice)
        {
            // Need to handle monthly invoice, however current app does not. No regression here
            $day_array = $this->time_service->getNumberedDayOfWeekArray();
            $renderer = new TimedInvoiceItemFormFieldsRenderer($day_array);
        } else {
            $renderer = new CountableInvoiceItemFormFieldsRenderer();
        }
        return $renderer;
    }
}
