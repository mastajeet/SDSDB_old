<?php
require_once('view/invoice/display_invoice/communication_method/FaxNumberRenderer.php');
require_once('view/invoice/display_invoice/communication_method/EmailAddressRenderer.php');

class TestCommunicationRenderer extends PHPUnit_Framework_TestCase
{
    const UN_NUMERO_DE_TELEPHONE = "4181234321";
    const UNE_ADRESSE_DE_COURRIEL = "info@thetest.com";
    private $content_array;


    /**
     * @before
     */
    function buildContentArray(){
        $this->content_array = array(
            'fax_number'=>self::UN_NUMERO_DE_TELEPHONE,
            'email_address'=>self::UNE_ADRESSE_DE_COURRIEL
        );
    }

    function test_givenBuiltFaxNumberRenderer_WhenRender_ObtainStringofFaxNumber()
    {
        $renderer = new FaxNumberRenderer();
        $renderer->buildContent($this->content_array);

        $html_output = $renderer->render();

        $this->assertEquals("<span class=Texte>(418) 123-4321</span> \n", $html_output);
    }

    function test_givenBuiltEmailAddressRenderer_whenRender_obtainStringofEmailAddress()
    {
        $renderer = new EmailAddressRenderer();
        $renderer->buildContent($this->content_array);

        $html_output = $renderer->render();

        $this->assertEquals('<span class=texte><b>Email</b> info@thetest.com</span> 
', $html_output);
    }
}
