<?php
require_once('view/HTMLHiddenEnvironmentFieldRenderer.php');

class TestHTMLUpdateFieldRenderer extends PHPUnit_Framework_TestCase
{
    private $content_array;
    const UN_ID = 2;

    /**
     * @before
     */
    function buildContentArray(){
        $this->content_array = array(
            'id'=>self::UN_ID
        );
    }

    function test_givenBuiltHTMLUpdateFieldRenderer_whenRender_obtainHTMLHiddenInputOfID()
    {
        $renderer = new HTMLHiddenEnvironmentFieldRenderer('id','id');
        $renderer->buildContent($this->content_array);

        $html_output = $renderer->render();

        $this->assertEquals('<input type=hidden name="id" value="'.self::UN_ID.'"> 
', $html_output);
    }
}
