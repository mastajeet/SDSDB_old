<?PHP
if(!isset($_POST['FORMCredit']))
	$_POST['FORMCredit']=0;
if(!isset($_POST['FORMMateriel']))
    $_POST['FORMMateriel']=0;
if(!isset($_POST['FORMAvanceClient']))
    $_POST['FORMAvanceClient']=0;
if(!isset($_POST['FORMTaxes']))
	$_POST['FORMTaxes']=FALSE;
	

	$Semaine = get_last_sunday(0,mktime(0,0,0,$_POST['FORMDate4'],$_POST['FORMDate5'],$_POST['FORMDate3']));
	$_GET['IDFacture'] = add_facture($_POST['FORMCote'],$Semaine,$_POST['FORMCredit'],$_POST['FORMNotes'],$_POST['FORMSeq'],$_POST['FORMMateriel'],$_POST['FORMTaxes']);
?>