<?php


class InvoiceSummaryDetailsRenderer extends HTMLContainerRenderer
{
    function __construct(Renderer $cote_renderer, Renderer $billing_period_renderer)
    {
        parent::__construct();
        $this->cote_renderer = $cote_renderer;
        $this->billing_period_renderer = $billing_period_renderer;
    }

    function buildContent($content_array)
    {
        $this->cote_renderer->buildContent($content_array);
        $this->billing_period_renderer->buildContent($content_array);

        $total_money_billed = $content_array['total_money_billed'];
        $total_hour_billed = $content_array['total_hour_billed'];
        $billing_datetime = $content_array['billing_datetime'];


        $this->html_container->AddTexte($this->cote_renderer->render(),'Titre');
        $this->html_container->br();
        $this->html_container->AddTexte("Heures Chargées: ",'Titre');
        $this->html_container->AddTexte($total_hour_billed);
        $this->html_container->br();
        $this->html_container->AddTexte("Total: ",'Titre');
        $this->html_container->AddTexte(number_format($total_money_billed,2)."&nbsp;$");
        $this->html_container->br();
        $this->html_container->AddTexte("Facturé le: ",'Titre');

        $this->html_container->AddTexte(date_format($billing_datetime,'j-m-Y'));

        $this->html_container->AddOutput($this->billing_period_renderer->render(),0);

    }
}