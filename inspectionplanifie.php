<?PHP
if(!isset($_GET['IDInspection'])){
	$INFO = array('IDEmploye'=>'','DateR'=>0,'DateP'=>0,'IDResponsable'=>'');
	$UPDATE = FALSE;
	$IDInstallation = $_GET['IDInstallation'];
}else{
	$INFO = get_info('inspection',$_GET['IDInspection']);
	$UPDATE = TRUE;
	$IDInstallation = $INFO['IDInstallation'];
}
$IInfo = get_info('installation',$IDInstallation);

$MainOutput->AddForm('Ajouter / Modifier un rendez-vous d\'inspection');
if(isset($_GET['IDInspection']))
	$MainOutput->InputHidden_Env('IDInspection',$_GET['IDInspection']);
$MainOutput->OpenRow();
$MainOutput->Opencol('100%',2);
	$MainOutput->AddTexte('<div align=center>'.$IInfo['Nom'].'
	
	</div>','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->InputHidden_Env('Action','PlanifieInspection');
$MainOutput->InputHidden_Env('UPDATE',$UPDATE);
$MainOutput->InputHidden_Env('IDInstallation',$IDInstallation);

$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE !Cessation ORDER BY Nom ASC";
$MainOutput->inputselect('IDEmploye',$Req,$INFO['IDEmploye'],'Inspecteur');
$MainOutput->inputselect('IDResponsable',get_responsable_client($IDInstallation),$INFO['IDResponsable'],'Contact');
$MainOutput->InputTime('DateR','Date de rappel',$INFO['DateR'],array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->InputTime('DateP','Date de l\'inspection',$INFO['DateP'],array('Date'=>TRUE,'Time'=>TRUE));
$MainOutput->FormSubmit('Ajouter / Modifier');
echo $MainOutput->Send(1);
?>