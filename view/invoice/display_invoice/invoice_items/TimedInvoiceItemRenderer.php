<?php
include_once('view/HTMLContainerRenderer.php');

class TimedInvoiceItemRenderer extends HTMLContainerRenderer
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

        $id = $content_array['id'];
        $invoice_item_datetime = $content_array['invoice_item_datetime'];
        $item_time_start = $content_array['start'];
        $item_time_end = $content_array['end'];
        $hourly_rate = $content_array['hourly_rate'];
        $notes = $content_array['notes'];
        $item_duration = $content_array['item_duration'];
        $item_total = $content_array['total'];

        $this->html_container->OpenRow();

        $this->html_container->OpenCol();
        $this->html_container->addoutput($this->invoice_item_controls_renderer->render());
        $this->html_container->AddTexte(date_format($invoice_item_datetime,'j-m-Y'));
        $this->html_container->CloseCol();

        $this->html_container->OpenCol();
        $this->html_container->AddTexte('<div align=center>'.$item_time_start.'</div>');
        $this->html_container->CloseCol();

        $this->html_container->OpenCol();
        $this->html_container->AddTexte($item_time_end);
        $this->html_container->CloseCol();

        $this->html_container->OpenCol();
        $this->html_container->AddTexte($notes);
        $this->html_container->CloseCol();

        $this->html_container->OpenCol();
        $this->html_container->AddTexte($item_duration);
        $this->html_container->CloseCol();

        $this->html_container->OpenCol();
        $this->html_container->AddTexte(number_format($hourly_rate,2)."&nbsp;$");
        $this->html_container->CloseCol();
        $this->html_container->OpenCol();
        $this->html_container->AddTexte(number_format($item_total,2)."&nbsp;$");
        $this->html_container->CloseCol();
        $this->html_container->CloseRow();
    }
}

