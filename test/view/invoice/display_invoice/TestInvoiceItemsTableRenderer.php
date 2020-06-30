<?php
require_once('view/invoice/display_invoice/invoice_items/TimedInvoiceItemTableRenderer.php');
require_once('view/invoice/display_invoice/invoice_items/CountableInvoiceItemTableRenderer.php');

class TestInvoiceItemTableRenderer extends PHPUnit_Framework_TestCase
{
    const UN_ID_ITEM_DE_FACTURE = "1";
    const UN_TIMESTAMP = 1591814361;
    const UNE_HEURE_DE_DEBUT = 10;
    const UNE_HEURE_DE_FIN = 13;
    const UN_TAUX_HORAIRE = 10.50;
    const UNE_NOTES = "une_note";
    const UNE_DUREE = 3;
    const UNE_VALEUR_TOTALE = 31.50;


    private $timed_invoice_items;
    private $countable_invoice_items;

    /**
     * @before
     */
    function buildContentArray(){
        $countable_invoice_item[] = array(
            'id'=>self::UN_ID_ITEM_DE_FACTURE,
            'description' => self::UNE_NOTES,
            'unit_cost'=> self::UN_TAUX_HORAIRE,
            'quantity' =>self::UNE_DUREE,
            'total' => self::UNE_VALEUR_TOTALE,
        );

        $timed_invoice_item[] = array(
            'id'=>self::UN_ID_ITEM_DE_FACTURE,
            'invoice_item_datetime'=> new Datetime("@".self::UN_TIMESTAMP),
            'start'=> self::UNE_HEURE_DE_DEBUT,
            'end' => self::UNE_HEURE_DE_FIN,
            'hourly_rate' => self::UN_TAUX_HORAIRE,
            'notes' => self::UNE_NOTES,
            'item_duration' =>self::UNE_DUREE,
            'total' => self::UNE_VALEUR_TOTALE,
        );
        $this->timed_invoice_items = ["invoice_items"=>$timed_invoice_item];
        $this->countable_invoice_items = ["invoice_items"=>$countable_invoice_item];
    }

    function test_givenBuiltTimedInvoiceItem_whenRender_obtainStringTableRowOfItem()
    {
        $renderer = new TimedInvoiceItemTableRenderer(new MockHTMLContainerRenderer());
        $renderer->buildContent($this->timed_invoice_items);

        $html_output = $renderer->render();

        $this->assertEquals($this->getTimedInvoiceItemTableOutput(),$html_output);
    }

    function test_givenBuiltCountableInvoiceItem_whenRender_obtainStringTableRowOfItem()
    {
        $renderer = new CountableInvoiceItemTableRenderer(new MockHTMLContainerRenderer());
        $renderer->buildContent($this->countable_invoice_items);

        $html_output = $renderer->render();

        $this->assertEquals($this->getCountableInvoiceItemTableOutput(),$html_output);
    }

    private function getTimedInvoiceItemTableOutput()
    {
        return '<table width="660" cellspacing=2 cellpadding=2 border=0 align=""> 
<tr height="" class=""> 
<td width="80" colspan=1 valign=top class=""> 
<span class=Titre>Date</span> 
</td> 
<td width="20" colspan=1 valign=top class=""> 
<span class=Titre><div align=center>Début</div></span> 
</td> 
<td width="20" colspan=1 valign=top class=""> 
<span class=Titre>Fin</span> 
</td> 
<td width="330" colspan=1 valign=top class=""> 
<span class=Titre>Description</span> 
</td> 
<td width="30" colspan=1 valign=top class=""> 
<span class=Titre>Qté</span> 
</td> 
<td width="70" colspan=1 valign=top class=""> 
<span class=Titre>Taux</span> 
</td> 
<td width="50" colspan=1 valign=top class=""> 
<span class=Titre>Total</span> 
</td> 
</tr> 
<tr height="" class=""> 
<td width="" colspan=1 valign=top class=""> 
 
<span class=texte>10-06-2020</span> 
</td> 
<td width="" colspan=1 valign=top class=""> 
<span class=texte><div align=center>10</div></span> 
</td> 
<td width="" colspan=1 valign=top class=""> 
<span class=texte>13</span> 
</td> 
<td width="" colspan=1 valign=top class=""> 
<span class=texte>une_note</span> 
</td> 
<td width="" colspan=1 valign=top class=""> 
<span class=texte>3</span> 
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

    private function getCountableInvoiceItemTableOutput()
    {
        return '<table width="660" cellspacing=2 cellpadding=2 border=0 align=""> 
<tr height="" class=""> 
<td width="50" colspan=1 valign=top class=""> 
<span class=Titre>Qté</span> 
</td> 
</td> 
<td width="460" colspan=1 valign=top class=""> 
<span class=Titre>Description</span> 
</td> 
<td width="70" colspan=1 valign=top class=""> 
<span class=Titre>Taux</span> 
</td> 
<td width="50" colspan=1 valign=top class=""> 
<span class=Titre>Total</span> 
</td> 
</tr> 
<tr height="" class=""> 
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

