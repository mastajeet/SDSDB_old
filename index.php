<?PHP

    error_reporting(E_ALL);
    ini_set('display_errors', 1);


extract($_REQUEST);
if(isset($_POST['Section'])){
$_GET['Section'] = $_POST['Section'];
}
date_default_timezone_set ('America/Montreal');

if(isset($_COOKIE['IDEmploye']) AND !isset($_COOKIE['CIESDS'])){
		setcookie('IDEmploye','',0);
	DIE("Veuillez Rafraîchir votre page");
}
	
if((isset($_COOKIE['CIESDS']) AND $_COOKIE['CIESDS']=="QC") OR (isset($_POST['FORMCIESDS']) AND $_POST['FORMCIESDS']=="QC")){
    include('mysql_class_qc.php');
	$SQL = new SQLclass();
}elseif((isset($_COOKIE['CIESDS']) AND $_COOKIE['CIESDS']=="MTL") OR (isset($_POST['FORMCIESDS']) AND $_POST['FORMCIESDS']=="MTL") ){
	include('mysql_class_mtl.php');
	$SQL = new SQLclass();
}else{
	include('mysql_class_qc.php');
	$SQL = new SQLclass();
}

include('class_html.php');

include('func_divers.php');
include('func_employe.php');
include('func_materiel.php');
include('func_client.php');
include('func_ajustement.php');
include('func_horaire.php');
include('func_saison.php');
include('func_date.php');
include('func_facture.php');
include('func_superadmin.php');
include('func_inspection.php');
$WarningOutput= new html;
$MainOutput = new html();

if(isset($_POST['ToPrint'])){
	$_GET['ToPrint'] = $_POST['ToPrint'];
}
if(!isset($_COOKIE['IDEmploye'])){
	include('staff/index2.php');
}else{
//$Req = "SELECT Status FROM employe WHERE IDEmploye=".$_COOKIE['IDEmploye'];
//$SQL->SELECT($Req);
//$Req = $SQL->FetchArray();
    if($_COOKIE['Bureau']==1 and (isset($_COOKIE['MP']) AND $_COOKIE['MP']==get_vars('MP'))){
	if(isset($Action))
		include('action.php');
	$MenuOutput = new html();
	if(!isset($_GET['Semaine']))
		$_GET['Semaine']=get_last_sunday();
	if(!isset($_GET['ToPrint']))
		$_GET['ToPrint']=FALSE;
	?>
	<head>
	<META>
	<title>Gestion Service de Sauveteur</title>
	<link rel="STYLESHEET" type="text/css" href="style.css">
	<link rel="STYLESHEET" type="text/css" href="horaire.css">
	</head>
	<body link=black alink=black vlink=black>
	<table>
	<tr>
	<?PHP
	if(!isset($_GET['ToPrint']) OR !$_GET['ToPrint']){
	?>
	<td width=250 valign=top><img src=logo.jpg width=250><br>
	<?PHP
	}
	
	 include('menu2.php'); 
		if(isset($_GET['Section']))
			$Section = $_GET['Section'];
		if(!isset($_GET['ToPrint']) OR !$_GET['ToPrint']){
		?>
		</TD>
		<?PHP
		}
	
	?><td valign=top width=800><?PHP 
	if(isset($Section))
		include('section.php'); 
		
		?></td>
	</tr>
	</table>
	</body>
	<?PHP
	
}else{
	include('staff/index2.php');
}	
	}
	?>
