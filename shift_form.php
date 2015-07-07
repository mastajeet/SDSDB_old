<?PHP
$MainOutput->addform('Ajouter / Modifier un quart de travail à un horaire officiel');
	if(isset($_GET['IDHoraire'])){
		$MainOutput->inputhidden_env('IDHoraire',$_GET['IDHoraire']);
	}
	$MainOutput->inputhidden_env('Action','Horshift');
if($Section="Shift_Form"){
	$MainOutput->inputhidden_env('Action','ShiftForm');
}else{
	$MainOutput->inputhidden_env('Action','Horshift');
}
$WhereVacances = "";
if(isset($_GET['IDHorshift'])){
	$Info = get_horshift_info($_GET['IDHorshift']);
	$MainOutput->inputhidden_env('Update',TRUE);
	$MainOutput->inputhidden_env('IDHorshift',$_GET['IDHorshift']);
}elseif(isset($_GET['IDShift'])){
    $Info = get_shift_info($_GET['IDShift']);
    $ShiftDay = $Info['Semaine'];

    for($i=0; $i<$Info['Jour']; $i++){
        $ShiftDay += get_day_length($ShiftDay);
    }
    $WhereVacances = "AND IDEmploye NOT IN(SELECT IDEmploye FROM vacances WHERE DebutVacances<=".$ShiftDay." and FinVacances>= ".$ShiftDay.")";

    $MainOutput->inputhidden_env('IDInstallation',$Info['IDInstallation']);
	$MainOutput->inputhidden_env('Update',TRUE);
	$MainOutput->inputhidden_env('IDShift',$_GET['IDShift']);
}else{
	$MainOutput->inputhidden_env('Update',FALSE);
	$Info = array('Salaire'=>'','IDEmploye'=>'','TXH'=>'','Jour'=>'','Start'=>'','End'=>'','Commentaire'=>'','Warn'=>'','Assistant'=>'0','Confirme'=>0);
}
$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
$MainOutput->inputselect('Jour',$CJour,$Info['Jour'],'Jour');
$MainOutput->inputtime('Start','Début',$Info['Start']);
$MainOutput->inputtime('End','Fin',$Info['End']);
$MainOutput->flag('Assistant',$Info['Assistant']);
$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE !Cessation ".$WhereVacances." ORDER BY Nom ASC, Prenom ASC";
$MainOutput->inputselect('IDEmploye',$Req,$Info['IDEmploye'],'Sauveteur');
$MainOutput->inputtext('Salaire','Salaire',4,$Info['Salaire']);
$MainOutput->inputtext('TXH','Taux Horaire',4,$Info['TXH']);
$MainOutput->textarea('Commentaire','Commentaire','25','2',$Info['Commentaire']);
$MainOutput->inputtext('Rec','Nb de récurrences','2');
if($Section=="Shift_Form"){
	$MainOutput->textarea('Warn','Pré-shit','25','2',$Info['Warn']);
	$MainOutput->flag('Confirme',$Info['Confirme'],'Heures Confirmées');
	}
$MainOutput->flag('Attach',1,'Attacher les shifts');


$MainOutput->formsubmit('Ajouter / Modifier');
echo $MainOutput->send(1);
?>