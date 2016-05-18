<?PHP
$Info = array('IDShift'=>0,'Date'=>'','IDEmploye'=>0,'IDInstallation'=>'','IDResponsable'=>'');
if(isset($_GET['IDShift'])){
	$SQL = new sqlclass();
	$Req = "SELECT employe.IDEmploye, shift.IDInstallation, shift.Semaine, shift.Jour, shift.Start FROM shift JOIN employe on shift.IDEmploye = employe.IDEmploye WHERE IDShift = ".$_GET['IDShift'];
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	$Info['IDShift']=$_GET['IDShift'];
	$Info['Date']= $Rep['Semaine']+$Rep['Jour']*3600*24+$Rep['Start'];
	$Info['IDEmploye']=$Rep['IDEmploye'];
	$Info['IDInstallation']=$Rep['IDInstallation'];;
}

$MainOutput->addform('Ajouter un commenataire');
$MainOutput->InputHidden_env('Action','Ajouter_Commentaire');
$MainOutput->InputHidden_env('IDShift',$Info['IDShift']);

$RespList = get_responsable_list($_COOKIE['IDClient']);
$MainOutput->inputSelect('IDResponsable',$RespList,$Info['IDResponsable'],'Responsable');

$EmplList = get_employe_list($_COOKIE['IDClient']);
$MainOutput->inputSelect('IDEmploye',$EmplList,$Info['IDEmploye'],'Employé');

$InsList = get_installation_list($_COOKIE['IDClient'],"ARRAY");
$MainOutput->inputSelect('IDInstallation',$InsList,$Info['IDInstallation'],'Installation');

$MainOutput->inputtime('Temps','Date et heure', $Info['Date'],array('Date'=>TRUE,'Time'=>True));

$MainOutput->textArea('Commentaire',NULL,50,10);

$MainOutput->FormSubmit('Poster');

?>
	