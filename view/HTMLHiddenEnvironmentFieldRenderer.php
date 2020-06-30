<?php


class HTMLHiddenEnvironmentFieldRenderer extends HTMLContainerRenderer
{
    private $field_name;
    private $content_array_key;

    function __construct($field_name, $content_array_key)
    {
        $this->field_name = $field_name;
        $this->content_array_key = $content_array_key;
        parent::__construct();
    }

    function buildContent($content_array)
    {
        $value = $content_array[$this->content_array_key];
        $this->html_container->inputhidden_env($this->field_name, $value);
    }
}
