<?PHP

$installation_value = array();
foreach($_POST as $k=>$v){
    if(substr($k,0,4)=="FORM"){
        if(substr($k,0,7)=='FORMTel'){
            $installation_value ['Tel'] = $_POST['FORMTel1'].$_POST['FORMTel2'].$_POST['FORMTel3'].$_POST['FORMTel4'];
        }else{
            $installation_value [substr($k,4)] = $v;
        }
    }else{
        if($k=="IDInstallation"){
            $installation_value[$k] = $v;
        }
        if($k=="IDClient"){
            $installation_value[$k] = $v;
        }
    }
}

$installation = new Installation($installation_value);
$installation->save();
$_GET['Section'] = "Display_Client";

?>