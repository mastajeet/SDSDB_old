<?php
include_once('view/HTMLContainerRenderer.php');
include_once('view/invoice/display_invoice/invoice_items/CountableInvoiceItemRenderer.php');

class CountableInvoiceItemTableRenderer extends HTMLContainerRenderer
{

    private $invoice_item_controls_renderer;

    function __construct(Renderer $invoice_item_controls_renderer)
    {
        $this->invoice_item_controls_renderer = $invoice_item_controls_renderer;
        parent::__construct();
    }

    function buildContent($content_array)
    {
        $this->buildInvoiceItemTableHeader();
        $this->buildInvoiceItemTableRows($content_array['invoice_items']);
    }

    private function buildInvoiceItemTableHeader()
    {
        $this->html_container->OpenTable(660);
        $this->html_container->OpenRow();

        $this->html_container->OpenCol(50);
        $this->html_container->AddTexte('Qté','Titre');
        $this->html_container->CloseCol();

        $this->html_container->CloseCol();
        $this->html_container->OpenCol(460);
        $this->html_container->AddTexte('Description','Titre');

        $this->html_container->CloseCol();
        $this->html_container->OpenCol(70);
        $this->html_container->AddTexte('Taux','Titre');
        $this->html_container->CloseCol();

        $this->html_container->OpenCol(50);
        $this->html_container->AddTexte('Total','Titre');
        $this->html_container->CloseCol();

        $this->html_container->CloseRow();
    }

    private function buildInvoiceItemTableRows($invoice_item_array)
    {
        foreach($invoice_item_array as $invoice_item){
            $invoice_item_renderer = new CountableInvoiceItemRenderer($this->invoice_item_controls_renderer);
            $invoice_item_renderer->buildContent($invoice_item);
            $this->html_container->addoutput($invoice_item_renderer->render(),0,0);
        }
    }
}
