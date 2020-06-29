<?php
require_once('view/invoice/display_invoice/HeaderRenderer.php');
require_once ('test/view/MockHTMLContainerRenderer.php');


class TestHeaderRenderer extends PHPUnit_Framework_TestCase
{
    const UN_PATH_VERS_IMAGE = "/assets/images/logo";
    const UN_TITRE_DE_FACTURE = "FACTURE";
    const NOMBRE_DE_COLONES_POUR_FACTURE_DE_TEMPS = 7;

    private $summary_details_renderer;
    private $recipient_details_renderer;
    private $title_renderer;
    private $content_array;

    /**
     * @before
     */
    function buildContentArray(){
        $this->content_array = array(
            'logo_path'=>self::UN_PATH_VERS_IMAGE
        );
        $this->summary_details_renderer = new MockHTMLContainerRenderer();
        $this->recipient_details_renderer = new MockHTMLContainerRenderer();
        $this->title_renderer = new MockHTMLContainerRenderer();
        $this->invoice_control_renderer = new MockHTMLContainerRenderer();
    }

    function test_givenBuiltHeaderRenderer_whenRender_obtainStringofHeader()
    {
        $renderer = new HeaderRenderer($this->title_renderer, $this->invoice_control_renderer, $this->summary_details_renderer,$this->recipient_details_renderer,self::NOMBRE_DE_COLONES_POUR_FACTURE_DE_TEMPS);
        $renderer->buildContent($this->content_array);

        $html_output = $renderer->render();

        $this->assertEquals($this->getHeaderString(), $html_output);
    }

    private function getHeaderString()
    {
return '<table width="660" cellspacing=2 cellpadding=2 border=0 align=""> 
<tr height="" class=""> 
<td width="20%" colspan=1 valign=top class=""> 
<img src="logo.jpg" > 
</td> 
<td width="80%" colspan=6 valign=top class=""> 
<div align=right> 
<span class=BigHead></span> 
<br />
 
 
</div> 
</td> 
</tr> 
<tr height="" class=""> 
<td width="20%" colspan=3 valign=top class=""> 
 
</td> 
<td width="80%" colspan=4 valign=top class=""> 
 
</td> 
</tr> 
<tr height="" class=""> 
<td width="" colspan=7 valign=top class=""> 
<span class=Titre>-----&nbsp;Détail&nbsp;-----------------------------------------------------------------------------------------------------------------------------------</span> 
</td> 
</tr> 
';
    }
}
