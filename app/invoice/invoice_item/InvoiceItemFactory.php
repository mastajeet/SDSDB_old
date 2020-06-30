<?php
include_once('app/invoice/invoice_item/CountableInvoiceItem.php');
include_once('app/invoice/invoice_item/TimedInvoiceItem.php');
include_once('app/invoice/invoice_item/CountableCreditedInvoiceItem.php');

class InvoiceItemFactory
{

    static function getTypedInvoiceItem($Arg, Invoice $invoice)
    {
        if ($invoice instanceof ShiftInvoice)
        {
            return new TimedInvoiceItem($Arg);
        }
        else if ($invoice instanceof Credit)
        {
            return new CountableCreditedInvoiceItem($Arg);
        }
        else
        {
            return new CountableInvoiceItem($Arg);
        }
    }

    static function getTypedInvoiceItemFromDTO($invoice_item_dto, Invoice $invoice)
    {
        if($invoice instanceof ShiftInvoice)
        {
            return TimedInvoiceItem::fromDetails($invoice_item_dto);
        }
        else if ($invoice instanceof Credit)
        {
            return CountableCreditedInvoiceItem::fromDetails($invoice_item_dto);
        }
        else
            {
            return CountableInvoiceItem::fromDetails($invoice_item_dto);
        }
    }
}
