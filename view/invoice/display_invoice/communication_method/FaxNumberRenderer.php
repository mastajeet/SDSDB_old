<?php
include_once('view/HTMLContainerRenderer.php');

class FaxNumberRenderer extends HTMLContainerRenderer
{
    function buildContent($content_array)
    {
        $fax_number = $content_array['fax_number'];
        $this->html_container->addphone($fax_number,true);
    }
}
