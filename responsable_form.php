<?PHP
$MainOutput->addform('Ajouter&nbsp;/&nbsp;Modifier&nbsp;une&nbsp;personne&nbsp;responsable');
	$MainOutput->inputhidden_env('Action','Responsable');
if(isset($_GET['IDResponsable'])){
	$Info = get_responsable_info($_GET['IDResponsable']);
	$MainOutput->inputhidden_env('IDResponsable',$_GET['IDResponsable']);
	$MainOutput->inputhidden_env('Update',TRUE);
}else{
	$Info = array('Nom'=>'','Cell'=>'418','Tel'=>'418','Appartement'=>'','Titre'=>'','Prenom'=>'');
	$MainOutput->inputhidden_env('Update',FALSE);
}
$Titre = array('Mme'=>'Mme','M.'=>'M.');
$MainOutput->inputselect('Titre',$Titre,$Info['Titre'],'Titre');
$MainOutput->inputtext('Prenom','Prenom','28',$Info['Prenom']);
$MainOutput->inputtext('Nom','Nom','28',$Info['Nom']);
$MainOutput->inputphone('Tel','Téléphone',$Info['Tel'],1);
$MainOutput->inputphone('Cell','Cellulaire',$Info['Cell']);
$MainOutput->inputtext('Appartement','#&nbsp;Appartement','3',$Info['Appartement']);
$MainOutput->formsubmit('Ajouter / Modifier');
echo $MainOutput->send(1);

?>
