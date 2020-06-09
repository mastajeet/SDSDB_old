<?php
include_once('app/invoice_item/InvoiceItem.php');

class countableInvoiceItem extends InvoiceItem
{
    function add_bill_item_to_balance(&$Balance){
        $Balance += round(($this->End - $this->Start)*$this->TXH,2);
    }
}
