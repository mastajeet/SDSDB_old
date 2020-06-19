<?php


class InvoiceRecipientDetailsRenderer extends HTMLContainerRenderer
{
    private $communication_method_renderer;

    function __construct(HTMLContainerRenderer $communcation_method_render)
    {
        $this->communication_method_renderer = $communcation_method_render;
        parent::__construct();
    }

    function buildContent($content_array)
    {
        $billed_to = $content_array['billed_to'];
        $billing_responsible = $content_array['billing_contact'];


        $this->html_container->AddTexte('Facturé: ','Titre');
        $this->html_container->AddTexte($billed_to);
        $this->html_container->br();
        $this->html_container->AddTexte('A/S: ','Titre');
        $this->html_container->AddTexte($billing_responsible);

    }
}
