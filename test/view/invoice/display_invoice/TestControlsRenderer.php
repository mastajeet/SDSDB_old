<?php
require_once('view/invoice/display_invoice/controls/InvoiceControlsRenderer.php');

class TestControlsRenderer extends PHPUnit_Framework_TestCase
{
    const UNE_COTE = "TCR";
    const UN_ID_DE_FACTURE = "1";
    private $invoice_control_content_array;

    /**
     * @before
     */
    function buildContentArray(){

        $this->invoice_control_content_array = array(
            'cote'=>self::UNE_COTE,
            'invoice_id'=>self::UN_ID_DE_FACTURE
        );
    }

    function test_givenBuiltInvoiceControlRenderer_whenRender_thenRenderStringOfControls()
    {
        $renderer = new InvoiceControlsRenderer();
        $renderer->buildContent($this->invoice_control_content_array);

        $html_output = $renderer->render();

        $this->assertEquals($this->getInvoiceControlString(), $html_output);
    }

    private function getInvoiceControlString()
    {
        return '<a href="index.php?Section=Factsheet&id=1" target="" ><span class=link><img src=assets/buttons/b_ins.png border=0></span></a> 
<span class=texte>&nbsp;</span> 
<a href="index.php?Section=Invoice_Display&ToPrint=TRUE&id=1" target="_BLANK" ><span class=link><img src=assets/buttons/b_print.png border=0></span></a> 
<span class=texte>&nbsp;</span> 
<a href="index.php?Section=Display_Facturation&Cote=TCR" target="" ><span class=link><img src=assets/buttons/b_fact.png border=0></span></a> 
<span class=texte>&nbsp;</span> 
<a href="index.php?Action=Delete_Facture&id=1" target="" ><span class=link><img src=assets/buttons/b_del.png border=0></span></a> 
';
    }

}

