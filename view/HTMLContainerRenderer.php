<?php
include_once('helper/Renderer.php');
include_once('view/HTMLContainer.php');
abstract class HTMLContainerRenderer implements Renderer
{
    protected $html_container;

    function __construct()
    {
        $this->html_container = new HTMLContainer();
    }

    function render()
    {
        return $this->html_container->send(1);
    }

    function builtContentAndRender($content_array){
        $this->buildContent($content_array);
        return $this->render();
    }


    abstract function buildContent($content_array);

}