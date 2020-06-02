<?PHP
$WarningOutput = new HTML;
$MainOutput = new HTML;
include('staff/action.php');
include('staff/functions.php');

include('helper/Authorization.php');
include('helper/PasswordGetter.php');
include('helper/ConstantArray.php');
include('func_divers.php');

include('app/Variable.php');


?>
<HTML>
<title>Gestion Service de Sauveteur</title>
<link rel="STYLESHEET" type="text/css" href="style.css">
<link rel="STYLESHEET" type="text/css" href="horaire.css">
</head>
<body link=black alink=black vlink=black>
<!-- HTML Généré après le 18 août... --!>
<table>
<tr>
<td width=250 valign=top><img src=logo.jpg width=250><br>
<?PHP
raisePresence();
 include('staff/menu.php'); 
	if(isset($_GET['Section']))
		$Section = $_GET['Section'];
	if(!isset($_GET['ToPrint']) OR !$_GET['ToPrint']){
?>
</TD>
<?PHP
}

?><td valign=top width=500><?PHP 
if(!isset($_COOKIE['IDEmploye'])){
	include('staff/login.php');
}  elseif (getnbconnections()>10) {
        include('toomuchconn.php');
}else{
	if(!isset($_REQUEST['Section']))
		$_REQUEST['Section'] = "Welcome";
	include('staff/section.php');
}
?></td>
</tr>
</table>
</body>




<body>
<table width=500>
<tr>
<td>
