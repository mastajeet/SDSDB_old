<?php
require_once('view/invoice/display_invoice/invoice_items/TimedInvoiceItemRenderer.php');
require_once('view/invoice/display_invoice/invoice_items/CountableInvoiceItemRenderer.php');

class TestInvoiceItemRenderer extends PHPUnit_Framework_TestCase
{
    const UN_ID_ITEM_DE_FACTURE = "1";
    const UN_TIMESTAMP = 1591814361;
    const UNE_HEURE_DE_DEBUT = 10;
    const UNE_HEURE_DE_FIN = 13;
    const UN_TAUX_HORAIRE = 10.50;
    const UNE_NOTES = "une_note";
    const UNE_DUREE = 3;
    const UNE_VALEUR_TOTALE = 31.50;

    private $countable_content_array;
    private $timed_content_array;

    /**
     * @before
     */
    function buildContentArray(){
        $this->timed_content_array = array(
            'id'=>self::UN_ID_ITEM_DE_FACTURE,
            'invoice_item_datetime'=> new Datetime("@".self::UN_TIMESTAMP),
            'start'=> self::UNE_HEURE_DE_DEBUT,
            'end' => self::UNE_HEURE_DE_FIN,
            'hourly_rate' => self::UN_TAUX_HORAIRE,
            'notes' => self::UNE_NOTES,
            'item_duration' =>self::UNE_DUREE,
            'total' => self::UNE_VALEUR_TOTALE,
        );

        $this->countable_content_array = array(
            'id'=>self::UN_ID_ITEM_DE_FACTURE,
            'notes' => self::UNE_NOTES,
            'unit_cost'=> self::UN_TAUX_HORAIRE,
            'item_quantity' =>self::UNE_DUREE,
            'total' => self::UNE_VALEUR_TOTALE,
        );

    }

    function test_givenBuiltTimedInvoiceItem_whenRender_obtainStringTableRowOfItem()
    {
        $renderer = new TimedInvoiceItemRenderer(new MockHTMLContainerRenderer());
        $renderer->buildContent($this->timed_content_array);

        $html_output = $renderer->render();

        $this->assertEquals($this->getTimedInvoiceItemOutput(),$html_output);
    }

    function test_givenBuiltCountableInvoiceItem_whenRender_obtainStringTableRowOfItem()
    {
        $renderer = new CountableInvoiceItemRenderer(new MockHTMLContainerRenderer());
        $renderer->buildContent($this->countable_content_array);

        $html_output = $renderer->render();

        $this->assertEquals($this->getCountableInvoiceItemOutput(),$html_output);
    }

    private function getTimedInvoiceItemOutput()
    {
        return "<tr height=\"\" class=\"\"> 
<td width=\"\" colspan=1 valign=top class=\"\"> 
 
<span class=texte>10-06-2020</span> 
</td> 
<td width=\"\" colspan=1 valign=top class=\"\"> 
<span class=texte><div align=center>10</div></span> 
</td> 
<td width=\"\" colspan=1 valign=top class=\"\"> 
<span class=texte>13</span> 
</td> 
<td width=\"\" colspan=1 valign=top class=\"\"> 
<span class=texte>une_note</span> 
</td> 
<td width=\"\" colspan=1 valign=top class=\"\"> 
<span class=texte>3</span> 
</td> 
<td width=\"\" colspan=1 valign=top class=\"\"> 
<span class=texte>10.50&nbsp;$</span> 
</td> 
<td width=\"\" colspan=1 valign=top class=\"\"> 
<span class=texte>31.50&nbsp;$</span> 
</td> 
</tr> 
";
    }

    private function getCountableInvoiceItemOutput()
    {
        return '<tr height="" class=""> 
<td width="" colspan=1 valign=top class=""> 
<span class=texte>3</span> 
</td> 
<td width="" colspan=1 valign=top class=""> 
<span class=texte>une_note</span> 
</td> 
<td width="" colspan=1 valign=top class=""> 
<span class=texte>10.50&nbsp;$</span> 
</td> 
<td width="" colspan=1 valign=top class=""> 
<span class=texte>31.50&nbsp;$</span> 
</td> 
</tr> 
';
    }
}

