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
        $this->html_container->AddLink('index.php?Section=InvoiceItem_Create&invoice_id='.$invoice_id,'<img src=assets/buttons/b_ins.png border=0 title="Ajouter un item à facturer">');
        $this->html_container->AddTexte('&nbsp;');
        $this->html_container->AddLink('index.php?Section=Invoice_Show&ToPrint=TRUE&invoice_id='.$invoice_id,'<img src=assets/buttons/b_print.png border=0 title="Imprimer la facture">','_BLANK');
        $this->html_container->AddTexte('&nbsp;');
        $this->html_container->AddLink('index.php?Section=DossierFacturation_Show&Cote='.$cote,'<img src=assets/buttons/b_fact.png border=0 title="Aller au dossier de facturation">');
        $this->html_container->AddTexte('&nbsp;');
        $this->html_container->AddLink('index.php?Action=Invoice_Delete&invoice_id='.$invoice_id,'<img src=assets/buttons/b_del.png border=0 title="Supprimer la facture">');
//        $this->html_container->AddOutput('</div>',0,0);
    }
}
