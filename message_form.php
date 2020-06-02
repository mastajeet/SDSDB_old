<?PHP 

if(isset($_GET['IDMessage'])){
	$MainOutput->AddForm('Modifier un message à tous');
	$MainOutput->inputhidden_env('Action','Message');
	$MainOutput->inputhidden_env('IDMessage',$_GET['IDMessage']);
	$Info = get_message_info($_GET['IDMessage']);
	$MainOutput->inputhidden_env('Update',TRUE);
}else{
	$MainOutput->AddForm('Ajouter un message à tous');
	$MainOutput->inputhidden_env('Action','Message');
	$Info = array('Start'=>time(),'Titre'=>'','Texte'=>'','IDEmploye'=>'','End'=>'');
	$MainOutput->inputhidden_env('Update',FALSE);
}
$MainOutput->InputText('Titre','Titre','28',$Info['Titre']);
$MainOutput->TextArea('Texte','Message',25,5,$Info['Texte']);
$MainOutput->InputTime('Start','Début',$Info['Start'],array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->InputTime('End','Fin',$Info['End'],array('Date'=>TRUE,'Time'=>FALSE));
$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE Status='Bureau' ORDER BY Nom ASC";
$MainOutput->InputSelect('IDEmploye',$Req,$Info['IDEmploye'],'Écrit Par');
$MainOutput->Formsubmit('Ajouter / Modifier');
echo $MainOutput->send();
?>