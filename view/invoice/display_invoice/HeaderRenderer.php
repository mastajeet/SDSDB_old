<?php


class HeaderRenderer extends HTMLContainerRenderer
{
    public $invoice_width;
    private $summary_details_renderer;
    private $recipient_details_renderer;
    private $invoice_controls_renderer;
    private $title_renderer;

    function __construct(Renderer $invoice_title_renderer, Renderer $invoice_controls_renderer, Renderer $summary_details_renderer, Renderer $recipient_details_renderer, $invoice_width)
    {
        $this->title_renderer = $invoice_title_renderer;
        $this->invoice_controls_renderer = $invoice_controls_renderer;
        $this->summary_details_renderer = $summary_details_renderer;
        $this->recipient_details_renderer = $recipient_details_renderer;
        $this->invoice_width = $invoice_width;
        parent::__construct();
    }

    function buildContent($content_array)
    {

        $this->title_renderer->buildContent($content_array);
        $this->invoice_controls_renderer->buildContent($content_array);
        $this->summary_details_renderer->buildContent($content_array);
        $this->recipient_details_renderer->buildContent($content_array);

        $this->html_container->OpenTable(1000);
        $this->html_container->OpenRow();
        $this->html_container->OpenCol('80%',$this->invoice_width-1);
        $this->html_container->AddPic('logo.jpg');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol();
        $this->html_container->AddTexte($this->title_renderer->render(),'BigHead'); #Titre
        $this->html_container->br();
        $this->html_container->AddOutput($this->invoice_controls_renderer->render(),0,0); #Controle pour modifications
        $this->html_container->CloseCol();
        $this->html_container->CloseRow();

        $this->html_container->OpenRow();
        $this->html_container->OpenCol('50%',floor($this->invoice_width/2));
        $this->html_container->addoutput($this->summary_details_renderer->render(),0,0); # Summary details
        $this->html_container->CloseCol();

        $this->html_container->OpenCol('50%',ceil($this->invoice_width/2));
        $this->html_container->addoutput($this->recipient_details_renderer->render(),0,0); # Summary details
        $this->html_container->CloseCol();

        $this->html_container->CloseRow();
        $this->html_container->OpenRow();
        $this->html_container->OpenCol('', $this->invoice_width );
        $this->html_container->AddTexte('-----&nbsp;Détail&nbsp;-----------------------------------------------------------------------------------------------------------------------------------------','Titre');
        $this->html_container->CloseCol();
        $this->html_container->CloseRow();


    }
}
