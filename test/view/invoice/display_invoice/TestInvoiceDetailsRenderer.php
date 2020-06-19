<?php
require_once('view/invoice/display_invoice/details/InvoiceSummaryDetailsRenderer.php');
require_once('view/invoice/display_invoice/details/InvoiceRecipientDetailsRenderer.php');
require_once('test/view/MockHTMLContainerRenderer.php');

class TestInvoiceDetailsRenderer extends PHPUnit_Framework_TestCase
{
    const UN_NOMBRE_HEURES_CHARGÉES = 3;
    const UN_MONTANT = 420.66;
    const UN_TIMESTAMP_DE_FACTURATION = "1583989200";
    const UN_TIMESTAMP_DE_DEBUT_DE_PERIODE = "1583643600";
    const UN_TIMESTAMP_DE_FIN_DE_PERIODE = "1584162000";
    const UNE_INSTALLATION = "la belle piscine";
    const UNE_PERSONNE_RESSOURCE = "Michel Michel \n 1080 thestreet";
    private $content_array_summary;
    private $content_array_recipient;
    private $cote_renderer;
    private $period_renderer;
    private $communication_method_renderer;

    /**
     * @before
     */
    function buildContentArray(){
        $this->content_array_summary = array(
//            'cote'=>self::UNE_COTE,
//            'sequence'=>self::UN_NUMERO_SEQUENTIEL,
            'total_money_billed'=>self::UN_MONTANT,
            'total_hour_billed'=>self::UN_NOMBRE_HEURES_CHARGÉES,
            'start_of_period_datetime'=> new DateTime("@".self::UN_TIMESTAMP_DE_DEBUT_DE_PERIODE),
            'end_of_period_datetime'=> new DateTime("@".self::UN_TIMESTAMP_DE_FIN_DE_PERIODE),
            'billing_datetime'=> new DateTime("@".self::UN_TIMESTAMP_DE_FACTURATION),
        );
        $this->content_array_recipient = array(
            'billed_to'=>self::UNE_INSTALLATION,
            'billing_contact'=>self::UNE_PERSONNE_RESSOURCE
            );
        $this->cote_renderer = new MockHTMLContainerRenderer();
        $this->period_renderer =  new MockHTMLContainerRenderer();
        $this->communication_method_renderer = new MockHTMLContainerRenderer();
    }

    function test_givenBuiltInvoiceSummaryRenderer_whenRender_thenObtainStringSummaryDetails()
    {
        $renderer = new InvoiceSummaryDetailsRenderer($this->cote_renderer, $this->period_renderer);
        $renderer->buildContent($this->content_array_summary);

        $this->assertEquals($this->getStringSummaryDetails(), $renderer->render());
    }

    function test_givenBuiltInvoiceRecipientDetailsRenderer_whenRender_thenObtainStringRendererDetails()
    {
        $renderer = new InvoiceRecipientDetailsRenderer($this->communication_method_renderer);
        $renderer->buildContent($this->content_array_recipient);

        $this->assertEquals($this->getStringRecipientDetails(), $renderer->render());
    }

    private function getStringSummaryDetails()
    {
        return '<span class=Titre></span> 
<br />
 
<span class=Titre>Heures Chargées: </span> 
<span class=texte>3</span> 
<br />
 
<span class=Titre>Total: </span> 
<span class=texte>420.66&nbsp;$</span> 
<br />
 
<span class=Titre>Facturé le: </span> 
<span class=texte>12-03-2020</span> 
<br />
 
<span class=Titre>Pour la période: </span> 
<span class=texte></span> 
';
    }

    private function getStringRecipientDetails()
    {
        return '<span class=Titre>Facturé: </span> 
<span class=texte>la belle piscine</span> 
<br />
 
<span class=Titre>A/S: </span> 
<span class=texte>Michel Michel <br />
 1080 thestreet</span> 
';
    }
}

