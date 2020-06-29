<?php
require_once('view/invoice/display_invoice/TitleRenderer.php');

class TestTitleRenderer extends PHPUnit_Framework_TestCase
{

    function test_givenBuiltTitleRendererWithEquipmentInvoice_whenRender_ObtainStringOfFactureMateriel()
    {
        $renderer = new TitleRenderer(new EquipmentInvoice(array()));
        $renderer->buildContent(array());

        $html_output = $renderer->render();

        $this->assertEquals("FACTURE MATÉRIEL", $html_output);
    }

    function test_givenBuiltCoteRendererWithShiftInvoiceQC_whenRender_ObtainStringofFacture()
    {
        $renderer = new TitleRenderer(new ShiftInvoice(array()));
        $renderer->buildContent(array());

        $html_output = $renderer->render();

        $this->assertEquals("FACTURE", $html_output);
    }

    function test_givenBuiltCoteRendererWithInterestInvoiceTR_whenRender_ObtainStringOfChargeInteret()
    {
        $renderer = new TitleRenderer(new InterestInvoice(array()));
        $renderer->buildContent(array());

        $html_output = $renderer->render();

        $this->assertEquals("CHARGE D'INTÉRÊT", $html_output);
    }

    function test_givenBuiltCoteRendererWithAvanceClientQC_whenRender_ObtainStringOfAvanceClient()
    {
        $renderer = new TitleRenderer(new AvanceClient(array()));
        $renderer->buildContent(array());

        $html_output = $renderer->render();

        $this->assertEquals("AVANCE", $html_output);
    }

    function test_givenBuiltCoteRendererWithCreditQC_whenRender_ObtainStringOfCredit()
    {
        $renderer = new TitleRenderer(new Credit(array()));
        $renderer->buildContent(array());

        $html_output = $renderer->render();

        $this->assertEquals("CRÉDIT", $html_output);
    }
}

