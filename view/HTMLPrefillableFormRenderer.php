<?php
include_once('view/HTMLHiddenEnvironmentFieldRenderer.php');
include_once('view/EmptyHTMLContainerRenderer.php');
include_once('helper/getOrDefault.php');

class HTMLPrefillableFormRenderer extends HTMLContainerRenderer
{
    private $title_renderer;
    private $action_renderer;
    private $method;
    private $fields_renderer;
    private $update_renderer;
    private $submit_text;

    private $action;
    private $section;
    private $route;

    function __construct($form_target, $update, $method, Renderer $title, Renderer $fields)
    {
        $this->method = $method;
        $this->update_renderer = $this->getUpdateRenderer($update);
        $this->submit_text = $this->getSubmitText($update);
        $this->title_renderer = $title;

        $this->route = $form_target["route"];
        $this->section = getOrDefault($form_target["section"],null);
        $this->action = getOrDefault($form_target["action"],null);

        $this->fields_renderer = $fields;

        parent::__construct();
    }

    function addTargetIfNotNull($name, $value)
    {
        if(!is_null($value) and !empty($value)){
            $this->html_container->inputhidden_env($name, $value);
        }
    }

    function buildContent($content_array)
    {
        $this->buildSubParts($content_array);
        $update = $this->update_renderer->render();
        $title = $this->title_renderer->render();
        $route = $this->route;
        $fields = $this->fields_renderer->render();

        $this->html_container->addform($title, $route, $this->method);
        $this->addTargetIfNotNull('Section',$this->section);
        $this->addTargetIfNotNull('Action',$this->action);
        $this->html_container->addoutput($update,0);
        $this->html_container->addoutput($fields, 0);
        $this->html_container->formsubmit($this->submit_text);
    }

    private function getUpdateRenderer($update)
    {
        if ($update)
        {
            $update_renderer = new HTMLHiddenEnvironmentFieldRenderer('id','id');
        } else {
            $update_renderer = new EmptyHTMLContainerRenderer();
        }
        return $update_renderer;
    }

    private function getSubmitText($update)
    {
        if ($update)
        {
            $submit_text = "Modifier";
        } else {
            $submit_text = "Ajouter";
        }
        return $submit_text;
    }

    /**
     * @param $content_array
     */
    private function buildSubParts($content_array)
    {
        $this->update_renderer->buildContent($content_array);
        $this->title_renderer->buildContent($content_array);
        $this->fields_renderer->buildContent($content_array);
    }
}
