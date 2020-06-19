<?php
require_once('view/invoice/display_invoice/CoteRenderer.php');

class TestCoteRenderer extends PHPUnit_Framework_TestCase
{
    const UNE_COTE = "TCR";
    const UN_NUMERO_SEQUENTIEL = "1";
    const COMPAGNIE_MTL = "MTL";
    const COMPAGNIE_QC = "QC";
    const COMPAGNIE_TR = "TR";
    private $content_array;

    /**
     * @before
     */
    function buildContentArray(){

        $this->content_array = array(
            'cote'=>self::UNE_COTE,
            'sequence'=>self::UN_NUMERO_SEQUENTIEL
        );
    }


    function test_givenBuiltCoteRendererWithEquipmentInvoiceMTL_whenRender_ObtainStringPrefixedWith_M_m()
    {
        $renderer = new CoteRenderer(new EquipmentInvoice(array()), self::COMPAGNIE_MTL);
        $renderer->buildContent($this->content_array);

        $html_output = $renderer->render();

        $this->assertEquals("M-mTCR-1", $html_output);
    }

    function test_givenBuiltCoteRendererWithShiftInvoiceQC_whenRender_ObtainStringPrefixedWithNothing()
    {
        $renderer = new CoteRenderer(new ShiftInvoice(array()), self::COMPAGNIE_QC);
        $renderer->buildContent($this->content_array);

        $html_output = $renderer->render();

        $this->assertEquals("TCR-1", $html_output);
    }

    function test_givenBuiltCoteRendererWithInterestInvoiceTR_whenRender_ObtainStringPrefixedWith_i()
    {
        $renderer = new CoteRenderer(new InterestInvoice(array()), self::COMPAGNIE_QC);
        $renderer->buildContent($this->content_array);

        $html_output = $renderer->render();

        $this->assertEquals("iTCR-1", $html_output);
    }

    function test_givenBuiltCoteRendererWithAvanceClientQC_whenRender_ObtainStringPrefixedWith_a()
    {
        $renderer = new CoteRenderer(new AvanceClient(array()), self::COMPAGNIE_QC);
        $renderer->buildContent($this->content_array);

        $html_output = $renderer->render();

        $this->assertEquals("aTCR-1", $html_output);
    }

    function test_givenBuiltCoteRendererWithCreditQC_whenRender_ObtainStringPrefixedWith_c()
    {
        $renderer = new CoteRenderer(new Credit(array()), self::COMPAGNIE_QC);
        $renderer->buildContent($this->content_array);

        $html_output = $renderer->render();

        $this->assertEquals("cTCR-1", $html_output);
    }
}

