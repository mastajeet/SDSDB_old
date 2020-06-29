<?php

include_once('helper/Renderer.php');

class TitleRenderer implements Renderer
{
    private $invoice_title_caption;
    private $title;

    function __construct(Invoice $invoice)
    {
        $this->invoice_title_caption = $this->getInvoiceTitleCaption($invoice);
        $this->title = "";
    }

    private function getInvoiceTitleCaption(Invoice $invoice)
    {
        if($invoice instanceof EquipmentInvoice) # Materiel
        {
            return "FACTURE MATÉRIEL";
        }
        else if($invoice instanceof AvanceClient)
        { # Avance
            return "AVANCE";
        }
        else if($invoice instanceof InterestInvoice)
        { # Intéret
            return "CHARGE D'INTÉRÊT";
        }
        else if($invoice instanceof Credit)
        { # Credit
            return "CRÉDIT";
        }else{
            return "FACTURE";
        }
    }

    function buildContent($content_array)
    {
        $this->title =  $this->invoice_title_caption;
    }

    function render()
    {
        return $this->title;
    }
}
