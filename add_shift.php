<?PHP
	$MainOutput->addform('Ajouter un shift');

	$MainOutput->inputhidden_env('Action','ShiftForm');
	$MainOutput->inputhidden_env('Update',FALSE);
if(isset($_GET['Semaine'])){
	$Upper = intval($_GET['Semaine']+6*86400);
	$Lower = intval($_GET['Semaine']);
	}else{
	$Upper = 0;
	$Lower = 0;
	}
	
	$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');	
	$MainOutput->FlagList('Jours',$CJour);
	$InstallationReq = "SELECT installation.IDInstallation, installation.Nom FROM `installation` WHERE Saison AND Actif ORDER BY installation.Nom ASC";
	$MainOutput->InputSelect('IDInstallation',$InstallationReq,'','Piscine');
	$MainOutput->InputTime('Start','Début',0,array('Date'=>FALSE,'Time'=>TRUE));
	$MainOutput->InputTime('End','Fin',0,array('Date'=>FALSE,'Time'=>TRUE));
	$MainOutput->InputTime('FROM','Commençant le',$Lower,array('Date'=>TRUE,'Time'=>FALSE));
	$MainOutput->InputTime('TO','Finissant le',$Upper,array('Date'=>TRUE,'Time'=>FALSE));
	$MainOutput->inputtext('Salaire','Salaire',4,'');
	$MainOutput->inputtext('TXH','Taux Horaire',4,'');
	$MainOutput->flag('Assistant');
	$MainOutput->textarea('Commentaire','Commentaire','25','2','');
	$MainOutput->formsubmit('Ajouter');
	echo $MainOutput->send(1);
?>	
