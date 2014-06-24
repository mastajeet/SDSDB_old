<?PHP


	$MainOutput->addform('Générer un horaire');
	$MainOutput->openrow();
	$MainOutput->opencol('100%',2);
	$MainOutput->addlink('index.php?Section=Horshift_Form&IDHoraire='.$_GET['IDHoraire'],'Ajouter un quart de travail précis');
	$MainOutput->closecol();
	$MainOutput->opencol();
	$MainOutput->closerow();
		
	$MainOutput->inputhidden_env('Action','Generate_Day');
	$MainOutput->inputhidden_env('IDHoraire',$_GET['IDHoraire']);
	$MainOutput->inputhidden_env('Update',FALSE);
	$Info = array('Salaire'=>'','TXH'=>'','Jour'=>'','Start'=>'','End'=>'','Commentaire'=>'','Assistant'=>'0');


$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');	

$MainOutput->FlagList('Jours',$CJour);

$MainOutput->inputtime('Start1','Début 1',$Info['Start']);
$MainOutput->inputtime('End1','Fin 1',$Info['End']);
$MainOutput->inputtime('Start2','Début 2',$Info['Start']);
$MainOutput->inputtime('End2','Fin 2',$Info['End']);
$MainOutput->inputtime('Start3','Début 3',$Info['Start']);
$MainOutput->inputtime('End3','Fin 3',$Info['End']);

$MainOutput->flag('Assistant',$Info['Assistant']);




$MainOutput->inputtext('Salaire','Salaire',4,$Info['Salaire']);
$MainOutput->inputtext('TXH','Taux Horaire',4,$Info['TXH']);
$MainOutput->textarea('Commentaire','Commentaire','25','2',$Info['Commentaire']);

$MainOutput->formsubmit('Ajouter / Modifier');

echo $MainOutput->send(1);
?>