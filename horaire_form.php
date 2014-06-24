<?PHP
$MainOutput->addform('Ajouter / Modifier un horaire');
$MainOutput->inputhidden_env('Action','Horaire');
if(isset($_GET['IDHoraire'])){
	$Info = get_horaire_info($_GET['IDHoraire']);
	$MainOutput->inputhidden_env('IDHoraire',$_GET['IDHoraire']);
	$MainOutput->inputhidden_env('Update',TRUE);
}else{
	$Info = array('Nom'=>'');
	$MainOutput->inputhidden_env('Update',FALSE);
}
$MainOutput->inputtext('Nom','Nom','28',$Info['Nom']);
$MainOutput->formsubmit('Ajouter / Modifier');
echo $MainOutput->send(1);

?>