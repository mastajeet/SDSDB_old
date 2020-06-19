<?php

include_once('helper/Renderer.php');

class CoteRenderer implements Renderer
{
    private $company_prefix;
    private $invoice_type_prefix;
    private $cote;

    function __construct(Invoice $invoice, $company)
    {
        $this->company_prefix = $this->getCompanyPrefix($company);
        $this->invoice_type_prefix = $this->getInvoiceTypePrefix($invoice);
        $this->cote = "";
    }

    private function getCompanyPrefix($company)
    {
        if($company == "MTL")
        {
            return "M-";
        }else{
            return "";
        }
    }

    private function getInvoiceTypePrefix(Invoice $invoice)
    {
        if($invoice instanceof EquipmentInvoice) # Materiel
        {
            return "m";
        }
        else if($invoice instanceof AvanceClient)
        { # Avance
            return "a";
        }
        else if($invoice instanceof InterestInvoice)
        { # Intéret
            return "i";
        }
        else if($invoice instanceof Credit)
        { # Credit
            return "c";
        }else{
            return "";
        }
    }

    function buildContent($content_array)
    {
        $cote = $content_array['cote'];
        $sequence = $content_array['sequence'];
        $this->cote =  $this->company_prefix.$this->invoice_type_prefix.$cote."-".$sequence;
    }

    function render()
    {
        return $this->cote;
    }
}
