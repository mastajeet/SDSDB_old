<?php

include_once('helper/Renderer.php');

class InvoiceItemControlsRenderer extends HTMLContainerRenderer
{
    function buildContent($content_array)
    {
        $invoice_item_id = $content_array['invoice_item_id'];
        $this->buildInvoiceItemsControlsTemplate($invoice_item_id);
    }

    private function buildInvoiceItemsControlsTemplate($invoice_item_id)
    {
//        $this->html_container->addlink('index.php?Section=Update_InvoiceItem&ID='.$id,'<img border=0 src=assets/buttons/b_edit.png>');
        $this->html_container->addlink('index.php?Section=Factsheet&IDFactsheet='.$invoice_item_id,'<img border=0 src=b_edit.png>');
    }
}
