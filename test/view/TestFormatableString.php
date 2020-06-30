<?php
require_once('view/FormatableString.php');

class TestFormatableString extends PHPUnit_Framework_TestCase
{
    private $content_array;
    const STRING_WITH_ONE_REPLACEMENT = "this string has {token_1} replacement";
    const STRING_WITH_TWO_REPLACEMENTS = "this string has {token_2} {token_3}";

    /**
     * @before
     */
    function buildContentArray(){
        $this->content_array = array(
            'token_1'=>"1",
            'token_2'=>"2",
            'token_3'=>'replacements'
        );
    }

    function test_givenBuiltFormatableStringWithOneReplacement_whenRender_obtainFormatedString()
    {
        $renderer = new FormatableString(self::STRING_WITH_ONE_REPLACEMENT);
        $renderer->buildContent($this->content_array);

        $output = $renderer->render();

        $this->assertEquals('this string has 1 replacement', $output);
    }


    function test_givenBuiltFormatableStringWithTwoReplacement_whenRender_obtainFormatedString()
    {
        $renderer = new FormatableString(self::STRING_WITH_TWO_REPLACEMENTS);
        $renderer->buildContent($this->content_array);

        $output = $renderer->render();

        $this->assertEquals('this string has 2 replacements', $output);
    }
}
