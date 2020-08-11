<?php
include_once('view/HTMLContainerRenderer.php');

class MonthlyBillingPeriodRenderer extends HTMLContainerRenderer
{
    function buildContent($content_array)
    {
        $datetime = $content_array['billing_period_datetime'];

        $this->html_container->br();
        $this->html_container->addTexte("Pour la période: ",'Titre');
        $this->html_container->addtexte(date_format($datetime,'F'));
    }
}
