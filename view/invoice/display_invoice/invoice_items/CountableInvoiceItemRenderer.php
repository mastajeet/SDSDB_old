<?php
include_once('view/HTMLContainerRenderer.php');

class CountableInvoiceItemRenderer extends HTMLContainerRenderer
{
    private $invoice_item_controls_renderer;

    function __construct(Renderer $invoice_item_controls_renderer)
    {
        $this->invoice_item_controls_renderer = $invoice_item_controls_renderer;
        parent::__construct();
    }

    function buildContent($content_array)
    {
        $this->invoice_item_controls_renderer->buildContent($content_array);

        $unit_cost = $content_array['unit_cost'];
        $notes = $content_array['description'];
        $item_quantity = $content_array['quantity'];
        $item_total = $content_array['total'];

        $this->html_container->OpenRow();

        $this->html_container->OpenCol();
        $this->html_container->addoutput($this->invoice_item_controls_renderer->render(),0,0);
        $this->html_container->AddTexte($item_quantity);
        $this->html_container->CloseCol();


        $this->html_container->OpenCol();
        $this->html_container->AddTexte($notes);
        $this->html_container->CloseCol();


        $this->html_container->OpenCol();
        $this->html_container->AddTexte(number_format($unit_cost,2)."&nbsp;$");
        $this->html_container->CloseCol();
        $this->html_container->OpenCol();
        $this->html_container->AddTexte(number_format($item_total,2)."&nbsp;$");
        $this->html_container->CloseCol();
        $this->html_container->CloseRow();
    }
}

