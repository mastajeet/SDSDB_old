<?php


class CountableInvoiceItemFormFieldsRenderer extends HTMLContainerRenderer
{

    function __construct()
    {
        parent::__construct();
    }

    function buildContent($content_array)
    {
        $description = getOrDefault($content_array["description"], null);
        $unit_cost = getOrDefault($content_array["unit_cost"], null);
        $quantity = getOrDefault($content_array["quantity"], null);
        $invoice_id = $content_array["invoice_id"];

        $this->html_container->inputhidden_env('invoice_id',$invoice_id);
        $this->html_container->InputText('description','Item','40',$description);
        $this->html_container->InputText('unit_cost','Prix unitaire',5,$unit_cost);
        $this->html_container->InputText('quantity','Quantité','1',$quantity);
    }
}
