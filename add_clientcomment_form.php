<?PHP
$SQL = new sqlclass;

if(!isset($_GET['IDInstallation'])){
	$_GET['IDInstallation']=0;
	$Rep[0]="";
}else{
	$Req  = "SELECT IDResponsable FROM installation WHERE IDInstallation=".$_GET['IDInstallation'];
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
}
	$MainOutput->AddForm('Ajouter le commentaire d\'un client');
	$MainOutput->inputhidden_env('Action','Add_ClientComment');

	
	$Req = "SELECT IDInstallation, installation.Nom FROM installation ORDER BY installation.Nom ASC";
	$MainOutput->inputselect('IDInstallation',$Req,$_GET['IDInstallation'],'IDInstallation');
	$Req = "SELECT DISTINCT responsable.IDResponsable, responsable.Nom, Prenom FROM installation JOIN client JOIN responsable ON installation.IDClient = client.IDClient AND (responsable.IDResponsable = installation.IDResponsable OR responsable.IDResponsable = RespP OR responsable.IDResponsable = RespF) ORDER BY Nom ASC, Prenom ASC";
	$MainOutput->inputselect('IDResponsable',$Req,$Rep[0],'Responsable');
	
	
	$MainOutput->inputtime('Date','Date',time(),array('Date'=>TRUE,'Time'=>FALSE));
	$MainOutput->TextArea('Comment','Commentaire');
	$MainOutput->TextArea('ToImprove','À améliorer');
	$MainOutput->TextArea('BeenImproved','À été améliorer');
	$MainOutput->formsubmit('Effectuer');
	echo $MainOutput->send(1);

?>