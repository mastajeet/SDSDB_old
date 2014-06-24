<?PHP
if(!isset($_GET['Cote']))
	$_GET['Cote']="";

	$MainOutput->AddForm('Ajouter une facture');
	$MainOutput->inputhidden_env('Action','Add_Facture');

	$SQL = new sqlclass;
	$Req = "SELECT Cote, Cote FROM installation WHERE Actif ORDER BY Cote ASC";
	
	$MainOutput->InputSelect('Cote',$Req,$_GET['Cote']);
	$MainOutput->inputtime('Date','Période','',array('Date'=>TRUE,'Time'=>FALSE));
	$MainOutput->InputText('Notes',$Rep['Notes']);
	$MainOutput->InputText('Seq','Séquence',2);
	$MainOutput->Flag('Materiel');
	$MainOutput->Flag('Taxes',1);
	$MainOutput->Flag('Credit');
	$MainOutput->formsubmit('Effectuer');
	echo $MainOutput->send(1);
?>
