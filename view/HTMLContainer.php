<?PHP
##########################################
#       CETTE CLASSE HTML ? ?T?          #
# PROGRAMM?E PAR L'UNIQUE ET FANTASTIQUE #
#             MASTAJEET                  #
#  UTILISATION PERMISE POUR L'AEACT      #
##########################################

class HTMLContainer
{
    var $output;
    var $formname;

    function addoutput($string,$nl2br=1,$strip=1){
        if($nl2br)
            $string = nl2br($string);
        if($strip)
            $string = stripslashes($string);
        $this->output .= $string." \n";
    }

    function addtitledoutput($title,$string){

        $str_full = "";
        $str_full .=  "<span class=Titre>".$title.": </span> ";
        $str_full .=  " ";
        $str_full .=  "<span class=Texte>".$string."</span>";
        $str_full .= "<br>";

        $this->addoutput($str_full);
    }

    function br($nb=1)	{
        $i=1;
        for($i; $i<=$nb; $i++)
        {
            $this->addoutput("\n",1);
        }
    }

    function center($string)	{
        return $output = "<div align=center>".$string."</div>";
    }

    function addtexte($string,$class="texte")	{
        $this->addoutput("<span class=$class>$string</span>");
    }


    function addlink($link,$texte="",$target="",$class="link",$title=NULL)	{
        if($texte==""){
            $texte=$link;
        }
        $titre = "";
        if(!is_null($title)){
            $titre = "title=\"".$title."\"";
        }
        $this->addoutput("<a href=\"".$link."\" target=\"".$target."\" ".$title."><span class=$class>".$texte."</span></a>");
    }

    function addpic($pic,$Property="",$link="",$target="")	{
        $Txt = "<img src=\"".$pic."\" ".$Property.">";
        if($link<>"")
            $this->addlink($link,$Txt,$target);
        if($link=="")
            $this->addoutput($Txt);
    }


    function send($empty=0)	{
        if($empty){
            $Ret = $this->output;
            $this->emptyoutput();
            return $Ret;
        }
        return $this->output;

    }

    function emptyoutput()	{
        $this->output="";
    }

    function reqinfo($Action, $Table)	{
        $this->inputhidden_env('Action', $Action);
        $this->inputhidden_env('Table', $Table);
    }

    function opentable($width="100%", $cellspacing=2, $cellpadding=2, $border=0, $align=""){
        $this->addoutput("<table width=\"".$width."\" cellspacing=".$cellspacing." cellpadding=".$cellpadding." border=".$border." align=\"".$align."\">");
    }

    function closetable()	{
        $this->addoutput("</table>");
    }

    function openrow($height='',$class='')	{
        $this->addoutput("<tr height=\"".$height."\" class=\"".$class."\">");
    }

    function closerow()	{
        $this->addoutput("</tr>");
    }

    function opencol($width="", $colspan="1", $valign="top",$class="",$other="")	{
        $this->addoutput("<td width=\"".$width."\" colspan=".$colspan." valign=".$valign." class=\"".$class."\">");
    }

    function closecol()	{
        $this->addoutput("</td>");
    }

    function opendiv($width)	{
        $this->opentable($width,0,0,0);
        $this->openrow();
        $this->opencol();
    }

    function closediv()	{
        $this->closecol();
        $this->closerow();
        $this->closetable();
    }


    function addtitledphone($title,$number,$IND=TRUE,$class='Texte'){

        $str_final = "";
        $str_final = "<span class='titre'>".$title.": </span><span class='texte'>";
        if(strlen($number>=7)){
            $str_final .= "(".substr($number,0,3).") ".substr($number,3,3)."-".substr($number,6,4);
            if(strlen(substr($number,10,4))>1)
                $str_final .= " #".substr($number,10,4);
        }
        $str_final .= "</span>";
        $str_final .= "<br>";
        $this->addoutput($str_final);
    }

    function addphone($number,$IND=FALSE,$class='Texte'){
        if(strlen($number>=7)){
            if($IND){
                $this->AddTexte("(".substr($number,0,3).") ".substr($number,3,3)."-".substr($number,6,4),$class);
                if(strlen(substr($number,10,4))>1)
                    $this->AddTexte(" #".substr($number,10,4));
            }else{
                $this->AddTexte(substr($number,3,3)."-".substr($number,6,4),$class);
                if(strlen(substr($number,10,4))>1)
                    $this->AddTexte(" #".substr($number,10,4));
            }
        }
    }

    function addform($titre=NULL, $action ="index.php", $method="POST", $name="FORM", $Jammed=FALSE)	{
        $this->formname = $name;
        if($Jammed)
            $this->opentable("60%",2,0);
        else
            $this->opentable("90%");
        $this->addoutput("<form name=\"".$name."\"  action=\"".$action."\" method=\"".$method."\">");
        $this->inputhidden_env("postname", $this->formname);
        if($titre<>NULL)
        {
            $this->openrow();
            $this->opencol('',2);
            $this->addtexte($this->center($titre), "titre");
            $this->closecol();
            $this->closerow();
        }
        $this->openrow();
        $this->opencol('20%');
        $this->closecol();
        $this->opencol('80%');
        $this->closecol();
        $this->closerow();

    }

    function postback($add){
        $this->inputhidden_env("PostBack", $_SERVER['HTTP_REFERER'].$add);
    }

    function inputfile($name, $description=NULL){
        if($description==NULL)
        {
            $description=$name;
        }
        $this->openrow();
        $this->opencol();
        $this->addtexte(ucfirst($description),"titre");
        $this->closecol();
        $this->opencol();
        $this->addoutput("<input type=file name=\"".$this->formname.$name."\" class=inputtext>");
        $this->closecol();
        $this->closerow();
    }

    function inputtext($name, $description=NULL, $size=28, $value="", $read_only=false){
        if($description==NULL)
        {
            $description=$name;
        }
        $read_only_as_string = "";
        if($read_only){
            $read_only_as_string = " disabled=\"disabled\" ";
            $this->inputhidden($name, $value);
        }
        $this->openrow();
        $this->opencol();
        $this->addtexte(ucfirst($description),"titre");
        $this->closecol();
        $this->opencol();
        $this->addoutput("<input $read_only_as_string type=text name=\"".$this->formname.$name."\" size=".$size." value=\"".$value."\" class=inputtext>");
        $this->closecol();
        $this->closerow();
    }

    function inputphone($name, $description=NULL, $value="",$EXT=FALSE){
        if($description==NULL)
        {
            $description=$name;
        }
        $this->openrow();
        $this->opencol();
        $this->addtexte(ucfirst($description),"titre");
        $this->closecol();
        $this->opencol();
        $this->addtexte("(");
        $this->addoutput("<input type=text name=\"".$this->formname.$name."1\" size=3 value=\"".substr($value,0,3)."\" class=inputtext>");
        $this->addtexte(")&nbsp;");
        $this->addoutput("<input type=text name=\"".$this->formname.$name."2\" size=3 value=\"".substr($value,3,3)."\" class=inputtext>");
        $this->addtexte("-");
        $this->addoutput("<input type=text name=\"".$this->formname.$name."3\" size=4 value=\"".substr($value,6,4)."\" class=inputtext>");
        if($EXT){
            $this->addtexte(" #");
            $this->addoutput("<input type=text name=\"".$this->formname.$name."4\" size=4 value=\"".substr($value,10,5)."\" class=inputtext>");
        }

        $this->closecol();
        $this->closerow();
    }

    function inputtime($name, $description=NULL, $value=0, $val=array('Date'=>False,'Time'=>True)){
        if($value=="")
            $value=0;
        $GETDATE = getdate($value);

        if($value==0){
            $Heure = "0";
            $Min = "0";
            $Jour = "";
            $Mois = "";
            $Year = Date("Y",time());
        }else{
            if($value>86400){

                $Jour = $GETDATE['mday'];
                $Mois = $GETDATE['mon'];
                $Year = $GETDATE['year'];
                $Min = $GETDATE['minutes'];
                $Heure = $GETDATE['hours'];
            }else{
                $Heure = floor($value/3600);
                $Min = floor(($value-$Heure*3600)/60);

            }
        }
        if($description==NULL){
            $description=$name;
        }
        $this->openrow();
        $this->opencol();
        $this->addtexte(ucfirst($description),"titre");
        $this->closecol();
        $this->opencol();

        if($val['Date']){
            $this->addoutput("<input type=text name=\"".$this->formname.$name."5\" size=2 maxlength=2 value=\"".$Jour."\" class=inputtext>");
            $this->addtexte("&nbsp;");
            $this->addoutput("<select name=\"".$this->formname.$name."4\" class=inputselect>");
            $this->addoutput("<option value=' '> </option>");
            $month = get_month_list();
            foreach($month as $v => $o){
                $text = "";

                if($v==$Mois){
                    $text = "SELECTED ";
                }
                $this->addoutput("<option value='".$v."' ".$text.">".$o."</option>");
            }
            $this->addoutput("</select>");
            $this->addtexte("&nbsp;");
            $this->addoutput("<input type=text name=\"".$this->formname.$name."3\" maxlength=4 size=4 value=\"".$Year."\" class=inputtext>");
            $this->addtexte("&nbsp;");
        }
        if($val['Time']){
            $this->addoutput("<input type=text name=\"".$this->formname.$name."2\" size=1 maxlength=2 value=\"".$Heure."\" class=inputtext>");
            $this->addtexte(":");
            $this->addoutput("<input type=text name=\"".$this->formname.$name."1\" size=1  maxlength=2 value=\"".$Min."\" class=inputtext>");
        }

        $this->closecol();
        $this->closerow();
    }

    function inputpassword($name, $description=NULL, $size=28, $value=""){
        if($description==NULL)
        {
            $description=$name;
        }
        $this->openrow();
        $this->opencol();
        $this->addtexte(ucfirst($description),"titre");
        $this->closecol();
        $this->opencol();
        $this->addoutput("<input type=password name=\"".$this->formname.$name."\" size=".$size." value=\"".$value."\" class=inputtext>");
        $this->closecol();
        $this->closerow();
    }

    function inputhidden($name,$value){
        $this->addoutput("<input type=hidden name=\"".$this->formname.$name."\" value=\"".$value."\">");
    }

    function inputradio($name,$value,$selected=NULL,$description=NULL,$align='HOR'){
        if($description==NULL)
        {
            $description=$name;
        }
        $this->openrow();
        $this->opencol();
        $this->addtexte(ucfirst($description),"titre");
        $this->closecol();
        $this->opencol();
        $this->opentable();

        if($align=='HOR'){
            $this->openrow();
            foreach($value as $desc => $val){
                $text="";
                if($val==$selected)
                    $text = "CHECKED";
                $this->opencol();
                $this->addoutput("<span class=texte>".$desc ."</span><input type=radio name=\"".$this->formname.$name."\" value=\"".$val."\" ".$text." class=inputradio class=inputradio>");
                $this->closecol();
            }
        }else{
            foreach($value as $val => $desc){
                $text="";
                if($val==$selected)
                    $text = "CHECKED";
                $this->openrow();
                $this->opencol();
                $this->addoutput("<input type=radio name=\"".$this->formname.$name."\" value=\"".$val."\" ".$text." class=inputradio class=inputradio><span class=texte> ".$desc ."</span>");
                $this->closecol();
                $this->closerow();
            }
        }
        $this->closetable();
        $this->closecol();
        $this->closerow();
    }

    function inputselect($name, $option, $selected=NULL, $description=NULL, $read_only=false){
        if($description==NULL)
        {
            $description=$name;
        }

        $disabled = "";
        if($read_only){
            $disabled = " disabled";
            $this->inputhidden($name, $selected );
        }
        $this->openrow();
        $this->opencol();
        $this->addtexte(ucfirst($description),"titre");
        $this->closecol();
        $this->opencol();
        $this->addoutput("<select ".$disabled." name=\"".$this->formname.$name."\" class=inputselect class=inputselect>");
        $this->addoutput("<option value=' '> </option>");

        if(is_array($option))
        {
            foreach($option as $value => $option)
            {
                $text = "";
                if($value==$selected)
                {
                    $text = "SELECTED ";
                }
                $this->addoutput("<option value='".$value."' ".$text.">".$option."</option>");
            }
        }else{
            $SQL = new SqlClass();
            $SQL->Select($option);
            while($rep = $SQL->fetcharray())
            {
                $text = "";
                if($rep[0]==$selected){
                    $text = "SELECTED ";
                }
                $this->addoutput("<option value='".$rep[0]."' ".$text.">".$rep[1]);
                if(isset($rep[2]))
                    $this->addoutput(" ".$rep[2]);
                if(isset($rep[3]))
                    $this->addoutput(" [".$rep[3]."]");
                $this->addoutput("</option>");
            }

        }
        $this->addoutput("</select>");
        $this->closecol();
        $this->closerow();
    }

    function textarea($name, $description=NULL, $width=25, $height=5, $value=""){
        if($description==NULL)	{
            $description=$name;
        }
        $this->openrow();
        $this->opencol();
        $this->addtexte(ucfirst($description),"titre");
        $this->closecol();
        $this->opencol();
        $this->addoutput("<textarea name=\"".$this->formname.$name."\" cols=\"".$width."\" rows=\"".$height."\" class=textarea>".$value."</textarea>",0);
        $this->closecol();
        $this->closerow();
    }

    function flag($name, $chk=0, $description=NULL)
    {
        $this->inputhidden($name, 0);

        $checked ="";
        if($chk==1)
        {
            $checked = "checked";
        }
        if($description==NULL)
        {
            $description=$name;
        }
        $this->openrow();
        $this->opencol();
        $this->addtexte(ucfirst($description),"titre");
        $this->closecol();
        $this->opencol();
        $this->addoutput("<input name=\"".$this->formname.$name."\" type=checkbox value=1 $checked>");
        $this->closecol();
        $this->closerow();
    }

    function checklist($name, $chk=0, $description=NULL)
    {
        $this->inputhidden($name, 0);

        $checked ="";
        if($chk==1){
            $checked = "checked";
        }
        if($description==NULL){
            $description=$name;
        }
        $this->openrow();

        $this->opencol(5);
        $this->addoutput("<input name=\"".$this->formname.$name."\" type=checkbox value=1 $checked>");
        $this->closecol();

        $this->opencol(1600);
                $this->addtexte(ucfirst($description),"titre");
        $this->closecol();
        $this->closerow();
    }


    function flaglist($name, $option, $selected=array(), $description=NULL)
    {
        // FAIRE LES MODIFICATION CAR MONT? EN BROCHE A FOIN
        if($description==NULL){
            $description=$name;
        }
        $this->openrow();
        $this->opencol();
        $this->addtexte(ucfirst($description),"titre");
        $this->closecol();
        $this->opencol();

        if(is_array($option)){
            $this->opentable();
            $this->openrow();
            foreach($option as $desc => $val){
                $this->opencol();
                $this->addoutput("<span class=texte>".$val."</span><input type=checkbox name=\"".$this->formname.$name.$desc."\" value=1 class=inputradio>");
                $this->closecol();
            }
            $this->closerow();
            $this->closetable();
        }else{

            $SQL = new SqlClass();
            $SQL->Select($option);
            $this->opentable();
            while($rep = $SQL->fetcharray()){
                $this->openrow();
                $this->opencol();
                $this->addoutput("<span class=texte>".$rep[1]." </span><input type=checkbox name=\"".$this->formname.$name.$rep[0]."\" value=1 class=inputradio>");
                $this->closecol();
                $this->closerow();
            }
            $this->closetable();
        }
        $this->closecol();
        $this->closerow();
    }

    function formsubmit($string='Exécuter'){
        $this->openrow();
        $this->opencol("",2);
        $this->addoutput($this->center("<input type=submit value=\"".$string."\"></form>"));
        $this->closecol();
        $this->closetable();
    }

    function inputhidden_env($name, $value)	{
        $this->addoutput("<input type=hidden name=\"".$name."\" value=\"".$value."\">");
    }


}