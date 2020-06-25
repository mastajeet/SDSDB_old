<?php
include_once('view/HTMLContainerRenderer.php');

class EmailAddressRenderer extends HTMLContainerRenderer
{
    function buildContent($content_array)
    {
        $email_address = $content_array['email_address'];
        $this->html_container->addtexte("<b>Email</b> ".$email_address);
    }
}
