<?php
include_once('view/invoice/display_invoice/controls/InvoiceItemControlsRenderer.php');
include_once('view/invoice/display_invoice/invoice_items/TimedInvoiceItemTableRenderer.php');
include_once('view/invoice/display_invoice/invoice_items/CountableInvoiceItemTableRenderer.php');



class BodyRendererFactory
{
    function getBodyRenderer(Invoice $invoice, $edit)
    {
        if ($edit) {
            $invoice_item_control_renderer = new InvoiceItemControlsRenderer();
        } else {
            $invoice_item_control_renderer = new EmptyHTMLContainerRenderer();
        }

        if ($invoice instanceof EquipmentInvoice or $invoice instanceof InterestInvoice)
        {
            return new CountableInvoiceItemTableRenderer($invoice_item_control_renderer);
        } else {
            return new TimedInvoiceItemTableRenderer($invoice_item_control_renderer);
        }

        throw new UnexpectedValueException();
    }

}
