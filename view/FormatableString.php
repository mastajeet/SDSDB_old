<?php

class FormatableString implements Renderer
{

    private $string_to_format;
    private $formated_string;

    function __construct($string_to_format)
    {
        $this->string_to_format = $string_to_format;

    }

    function buildContent($content_array)
    {
        $this->formated_string = $this->string_to_format;

        preg_match_all("/\{(\w+)\}/",$this->string_to_format,$occurences);

        foreach(array_combine($occurences[0], $occurences[1]) as $token=>$replacement_key)
        {
            $this->formated_string = str_replace($token, $content_array[$replacement_key],$this->formated_string);
        }
    }

    function render()
    {
        return $this->formated_string;
    }


}