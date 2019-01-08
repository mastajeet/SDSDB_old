<?PHP
    ini_set("default_charset", "iso-8859-1");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    setlocale(LC_TIME, 'fr_CA');


extract($_REQUEST);
if(isset($_POST['Section'])){
	$_GET['Section'] = $_POST['Section'];
}
date_default_timezone_set ('America/Montreal');

if(isset($_COOKIE['IDEmploye']) AND !isset($_COOKIE['CIESDS'])){
		setcookie('IDEmploye','',0);
	DIE("Veuillez Rafraichir votre page");
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

include('constants.php');

include_once('app/shift.php');
include_once('app/installation.php');
include_once('app/inspection.php');
include_once('app/shift.php');
include_once('app/factsheet.php');
include_once('app/logshift.php');
include_once('app/customer.php');
include_once('app/facture/facture.php');
include_once('app/facture/avanceClient.php');
include_once('app/Variable.php');
include_once('app/employee.php');
include_once('app/Responsable.php');
include_once('app/Secteur.php');
include_once('app/dossierFacturation.php');
include_once('app/payment.php');

include_once('helper/Authorization.php');
include_once('helper/PasswordGetter.php');
include_once('helper/ModelToKVPConverter.php');
include_once('helper/ConstantArray.php');
include_once('helper/TimeService.php');


$variable = new Variable();
$password_getter = new PasswordGetter($variable);
$authorization = new Authorization($password_getter);
$time_service = new TimeService();

$WarningOutput= new html;
$MainOutput = new html();


if(isset($_POST['ToPrint'])){
	$_GET['ToPrint'] = $_POST['ToPrint'];
}
if(!isset($_COOKIE['IDEmploye'])){
	include('staff/index2.php');
}else{
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

         include('menu.php');
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
