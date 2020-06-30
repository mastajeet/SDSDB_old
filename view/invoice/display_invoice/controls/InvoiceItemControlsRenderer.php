<?php

include_once('helper/Renderer.php');

class InvoiceItemControlsRenderer extends HTMLContainerRenderer
{
    function buildContent($content_array)
    {
        $invoice_item_id = $content_array['invoice_item_id'];
        $invoice_id = $content_array['invoice_id'];
        $this->buildInvoiceItemsControlsTemplate($invoice_id, $invoice_item_id);
    }

    private function buildInvoiceItemsControlsTemplate($invoice_id, $invoice_item_id)
    {

        $this->html_container->addlink('index.php?Section=InvoiceItem_Edit&invoice_id='.$invoice_id.'&invoice_item_id='.$invoice_item_id,'<img border=0 src=assets/buttons/b_edit.png>');
    }
}
