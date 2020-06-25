<?php

include_once('helper/Renderer.php');

class InvoiceControlsRenderer extends HTMLContainerRenderer
{
    function buildContent($content_array)
    {
        $invoice_id = $content_array['invoice_id'];
        $cote = $content_array['cote'];
        $this->buildInvoiceControlsTemplate($invoice_id, $cote);
    }

    private function buildInvoiceControlsTemplate($invoice_id, $cote)
    {
//        $this->html_container->AddOutput('<div align=Right>',0,0);
        $this->html_container->AddLink('index.php?Section=Factsheet&id='.$invoice_id,'<img src=assets/buttons/b_ins.png border=0>');
        $this->html_container->AddTexte('&nbsp;');
        $this->html_container->AddLink('index.php?Section=Invoice_Display&ToPrint=TRUE&id='.$invoice_id,'<img src=assets/buttons/b_print.png border=0>','_BLANK');
        $this->html_container->AddTexte('&nbsp;');
        $this->html_container->AddLink('index.php?Section=Display_Facturation&Cote='.$cote,'<img src=assets/buttons/b_fact.png border=0>');
        $this->html_container->AddTexte('&nbsp;');
        $this->html_container->AddLink('index.php?Action=Delete_Facture&id='.$invoice_id,'<img src=assets/buttons/b_del.png border=0>');
//        $this->html_container->AddOutput('</div>',0,0);
    }
}
