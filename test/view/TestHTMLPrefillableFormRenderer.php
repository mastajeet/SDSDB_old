<?php
require_once('view/HTMLPrefillableFormRenderer.php');

class TestHTMLPrefillableFormRenderer extends PHPUnit_Framework_TestCase
{

    private $insert_content_array;
    private $update_content_array;

    const UN_NOM_DE_FORMULAIRE = "monForm";
    const UNE_METHOD = "POST";
    const FORMULAIRE_DE_MISE_A_JOUR = true;
    const FORMULAIRE_DINSERTION = false;
    const UN_ID = 2;
    const UNE_ROUTE = "index.php";
    const UNE_SECTION = "RESSOURCE_VERB";

    private $form_target;
    /**
     * @before
     */
    function buildContentArray(){
        $this->insert_content_array = array(
            'form_name'=>self::UN_NOM_DE_FORMULAIRE,
            'post_action_id'=>self::UN_ID
        );
        $this->update_content_array = array(
            'id_to_update'=>self::UN_ID,
            'post_action_id'=>self::UN_ID,
        );
        $this->form_target = array(
            "route"=>self::UNE_ROUTE,
            "section"=>self::UNE_SECTION,
            "action"=>''
        );
    }

    function test_givenBuiltHTMLPrefillableFormRendererForInsert_whenRender_obtainHTMLOfForm()
    {
        $renderer = new HTMLPrefillableFormRenderer($this->form_target, self::FORMULAIRE_DINSERTION, "POST", new MockHTMLContainerRenderer(),new MockHTMLContainerRenderer(),new MockHTMLContainerRenderer());
        $renderer->buildContent($this->insert_content_array);

        $html_output = $renderer->render();

        $this->assertEquals($this->getInsertFormHtmlOutput(), $html_output);
    }

    function test_givenBuiltHTMLPrefillableFormRendererForUpdate_whenRender_obtainHTMLOfForm()
    {
        $renderer = new HTMLPrefillableFormRenderer($this->form_target, self::FORMULAIRE_DE_MISE_A_JOUR, "POST", new MockHTMLContainerRenderer(),new MockHTMLContainerRenderer(),new MockHTMLContainerRenderer());
        $renderer->buildContent($this->update_content_array);

        $html_output = $renderer->render();

        $this->assertEquals($this->getUpdateFormHtmlOutput(), $html_output);
    }

    private function getInsertFormHtmlOutput()
    {
        return '<table width="90%" cellspacing=2 cellpadding=2 border=0 align=""> 
<form name="FORM"  action="index.php" method="POST"> 
<input type=hidden name="postname" value="FORM"> 
<tr height="" class=""> 
<td width="20%" colspan=1 valign=top class=""> 
</td> 
<td width="80%" colspan=1 valign=top class=""> 
</td> 
</tr> 
<input type=hidden name="Section" value="RESSOURCE_VERB"> 
 
<input type=hidden name="post_action_id" value="2"> 
 
 
<tr height="" class=""> 
<td width="" colspan=2 valign=top class=""> 
<div align=center><input type=submit value="Ajouter"></form></div> 
</td> 
</table> 
';
    }

    private function getUpdateFormHtmlOutput()
    {
        return '<table width="90%" cellspacing=2 cellpadding=2 border=0 align=""> 
<form name="FORM"  action="index.php" method="POST"> 
<input type=hidden name="postname" value="FORM"> 
<tr height="" class=""> 
<td width="20%" colspan=1 valign=top class=""> 
</td> 
<td width="80%" colspan=1 valign=top class=""> 
</td> 
</tr> 
<input type=hidden name="Section" value="RESSOURCE_VERB"> 
<input type=hidden name="id_to_update" value="2"> 
 
<input type=hidden name="post_action_id" value="2"> 
 
 
<tr height="" class=""> 
<td width="" colspan=2 valign=top class=""> 
<div align=center><input type=submit value="Modifier"></form></div> 
</td> 
</table> 
';
    }
}
