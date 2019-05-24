<?PHP 
include('../func_date.php');
include('functions.php');
include('../class_html.php');


if(isset($_COOKIE['CIE'])){
	if($_COOKIE['CIE']=="QC")
		include('../mysql_class_qc.php');
	if($_COOKIE['CIE']=="MTL")
		include('../mysql_class_mtl.php');
    if($_COOKIE['CIE']=="TR")
        include('../mysql_class_tr.php');

    $SQL =  new sqlclass();
}elseif(isset($_POST['FORMCIE'])){
	if($_POST['FORMCIE']=="QC")
		include('../mysql_class_qc.php');
    if($_POST['FORMCIE']=="MTL")
        include('../mysql_class_mtl.php');
    if($_POST['FORMCIE']=="TR")
        include('../mysql_class_tr.php');
		
	$SQL =  new sqlclass();
}



date_default_timezone_set ('America/Montreal');

$WarnOutput = new HTML();
include('action.php') ;



$MainOutput = new HTML();
$MenuOutput = new HTML();


if(!isset($_GET['Section']))
	$_GET['Section']="";

if(isset($_COOKIE['IDClient']))
	$ClientInfo = get_client_info($_COOKIE['IDClient']);
?>

<html>
<head>
	<title>Logiciel de gestion Service de sauveteurs - Accès client</title>
	<link rel="STYLESHEET" type="text/css" href="../horaire.css">
	<link rel="STYLESHEET" type="text/css" href="../style.css">
</head>

<body>
<table width=800>
<tr>
<td width=200 valign=top><img src=../logo.jpg width=250><br><?php include('menu.php') ?></td>
<td width=600 valign=top>

<?php
echo $WarnOutput->Send(1);
if(!isset($_COOKIE['IDClient']))
	include('form_login.php');
else{
if($ClientInfo['NBAcces']<=0)
	$_GET['Section']="Modifier_Password";
	
	include('section.php') ;
}
 ?></td>

</tr>
</table> 








</body>
</html>
