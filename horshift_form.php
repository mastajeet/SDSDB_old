<?PHP
	$MainOutput->addform('Ajouter / Modifier un quart de travail à un horaire officiel');
	$MainOutput->inputhidden_env('Action','Horshift');
if(isset($_GET['IDHorshift'])){
	$Info = get_horshift_info($_GET['IDHorshift']);
	$MainOutput->inputhidden_env('IDHoraire',$Info['IDHoraire']);
	$MainOutput->inputhidden_env('Update',TRUE);
	$MainOutput->inputhidden_env('IDHorshift',$_GET['IDHorshift']);
}else{
	$MainOutput->inputhidden_env('IDHoraire',$_GET['IDHoraire']);
	$MainOutput->inputhidden_env('Update',FALSE);
	$Info = array('Salaire'=>'','TXH'=>'','Jour'=>'','Start'=>'','End'=>'','IDEmploye'=>'','Commentaire'=>'','Assistant'=>'0');
}
$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
$MainOutput->inputselect('Jour',$CJour,$Info['Jour'],'Jour');
$MainOutput->inputtime('Start','Début',$Info['Start']);
$MainOutput->inputtime('End','Fin',$Info['End']);

$MainOutput->inputselect('IDEmploye',$employeeList ,$Info['IDEmploye'],'Sauveteur');
$MainOutput->flag('Assistant',$Info['Assistant']);
$MainOutput->inputtext('Salaire','Salaire',4,$Info['Salaire']);
$MainOutput->inputtext('TXH','Taux Horaire',4,$Info['TXH']);
$MainOutput->textarea('Commentaire','Commentaire','25','2',$Info['Commentaire']);
$MainOutput->flag('Attach',1,'Attacher les shiftFormatter');
$MainOutput->flag('Confirm',$Info['Confirm'],'Horaire Accepté');
$MainOutput->formsubmit('Ajouter / Modifier');
echo $MainOutput->send(1);
?>