<?php

class HTMLInvoiceRenderer extends HTMLContainerRenderer
{
    private $header_renderer;
    private $body_renderer;
    private $footer_renderer;

    function __construct(HTMLContainerRenderer $header_renderer, HTMLContainerRenderer $body_renderer, HTMLContainerRenderer $footer_renderer )
    {
        $this->header_renderer = $header_renderer;
        $this->body_renderer = $body_renderer;
        $this->footer_renderer = $footer_renderer;
        parent::__construct();
    }

    function buildContent($content_array)
    {
        $this->header_renderer->buildContent($content_array);
        $this->body_renderer->buildContent($content_array);
        $this->footer_renderer->buildContent($content_array);

        $this->html_container->addoutput($this->header_renderer->render(),0);
        $this->html_container->addoutput($this->body_renderer->render(),0);
        $this->html_container->addoutput($this->footer_renderer->render(),0);
    }
}
