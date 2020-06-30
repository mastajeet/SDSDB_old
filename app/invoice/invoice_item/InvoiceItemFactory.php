<?php
include_once('app/invoice/invoice_item/CountableInvoiceItem.php');
include_once('app/invoice/invoice_item/TimedInvoiceItem.php');

class InvoiceItemFactory
{

    function getTypedInvoiceItem($Arg, Invoice $invoice)
    {
        if ($invoice instanceof ShiftInvoice)
        {
            return new TimedInvoiceItem($Arg);
        } else {
            return new CountableInvoiceItem($Arg);
        }
    }
}
