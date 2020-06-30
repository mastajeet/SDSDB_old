<?PHP
    const MTL="MTL";
    const TR="TR";
    const QC="QC";

    ini_set("default_charset", "iso-8859-1");
//    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    setlocale(LC_TIME, 'fr_CA');

extract($_REQUEST);
if(isset($_POST['Section'])){
	$_GET['Section'] = $_POST['Section'];
}
date_default_timezone_set ('America/Montreal');


function select_company_for_login($post_resquest_value){
    return select_company($post_resquest_value, "FORMCIESDS");
}

function select_company_when_logged($cookie){
    return select_company($cookie, "CIESDS");
}

function select_company($array, $field){
	SWITCH($array[$field]) {
        CASE "QC":{
                $company = QC;
                BREAK;
            }
        CASE "MTL":{
                $company = MTL;
                BREAK;
            }
        CASE "TR":{
                $company = TR;
                BREAK;
            }
        default :{
                $company = QC;
                BREAK;
            }
    }

    return $company;
}

function get_sql_class_filename($company){
    SWITCH($company) {
        CASE QC:{
                $filename = "mysql_class_qc.php";
                BREAK;
            }
        CASE MTL:{
                $filename = "mysql_class_mtl.php";
                BREAK;
            }
        CASE TR:{
                $filename = "mysql_class_tr.php";
                BREAK;
            }
        default :{
                $filename = "mysql_class_qc.php";
                BREAK;
            }
    }

    return $filename;
}

function is_logged($cookie){
    return isset($cookie['CIESDS']);
}

function is_login($post){
    return isset($post['FORMCIESDS']);
}

if(is_logged($_COOKIE)){
    $company = select_company_when_logged($_COOKIE);
}elseif(is_login($_POST)){
    $company = select_company_for_login($_POST);
}else{
    $company = QC;
}

$class_sql_filename = get_sql_class_filename($company);
include($class_sql_filename);
$SQL = new SQLclass();




if(isset($_COOKIE['IDEmploye']) AND !isset($_COOKIE['CIESDS'])){
		setcookie('IDEmploye','',0);
	DIE("Veuillez Rafraichir votre page");
}

include('view/HTMLContainer.php');

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

include_once('app/invoice/invoice_item/TimedInvoiceItem.php');
include_once('app/invoice/invoice_item/CountableInvoiceItem.php');
include_once('app/invoice/invoice_item/InvoiceItemFactory.php');
include_once('app/logshift.php');
include_once('app/customer.php');
include_once('app/invoice/invoice.php');
include_once('app/invoice/InvoiceService.php');
include_once('app/invoice/avanceClient.php');
include_once('app/horaire/horaire.php');
include_once('app/horaire/horaireFactory.php');
include_once('app/Variable.php');
include_once('app/employee.php');
include_once('app/responsable.php');
include_once('app/Secteur.php');
include_once('app/invoice/invoiceFactory.php');
include_once('app/dossier_facturation/dossierFacturation.php');

include_once('app/payment/payment.php');
include_once('app/payment/paymentService.php');


include_once('helper/Authorization.php');
include_once('helper/PasswordGetter.php');
include_once('helper/ModelToKVPConverter.php');
include_once('helper/ConstantArray.php');
include_once('helper/TimeService.php');
include_once('helper/getOrDefault.php');

include_once('view/HTMLContainerRenderer.php');
include_once('view/FormatableString.php');
include_once('view/HTMLPrefillableFormRenderer.php');

include_once('view/invoice/invoice_item/InvoiceItemFormFieldsRendererFactory.php');
include_once('view/invoice/display_invoice/HeaderRendererFactory.php');
include_once('view/invoice/display_invoice/BodyRendererFactory.php');
include_once('view/invoice/display_invoice/FooterRenderer.php');
include_once('view/invoice/display_invoice/HTMLInvoiceRenderer.php');

include_once('view/employee/CSVEmployeeSummaryListRenderer.php');

$variable = new Variable();
$password_getter = new PasswordGetter($variable);
$authorization = new Authorization($password_getter);
$time_service = new TimeService();

$notes = $variable->get_value("NoteFacture");
$tvq = $variable->get_value("TVQ");
$tps= $variable->get_value("TPS");
$facture_service = new InvoiceService($notes, $tps, $tvq);
$payment_service  = new PaymentService($facture_service);

$WarningOutput= new HTMLContainer();
$MainOutput = new HTMLContainer();


if(isset($_POST['ToPrint'])){
	$_GET['ToPrint'] = $_POST['ToPrint'];
}
if(!isset($_COOKIE['IDEmploye'])){
	include('staff/index2.php');
}else{
    if($_COOKIE['Bureau']==1 and (isset($_COOKIE['MP']) AND $_COOKIE['MP']==get_vars('MP'))){
        if(isset($Action))
            include('action.php');
        $MenuOutput = new HTMLContainer();
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
        echo $WarningOutput->send(1);
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
