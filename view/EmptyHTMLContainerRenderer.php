<?php
include_once('view/HTMLContainerRenderer.php');

class EmptyHTMLContainerRenderer extends   HTMLContainerRenderer
{
    function buildContent($content_array)
    {
        return "";
    }
}
