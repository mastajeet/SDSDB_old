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
    $WhereVacances = "AND employe.IDEmploye NOT IN(SELECT vacances.IDEmploye FROM vacances WHERE DebutVacances<=".$ShiftDay." and FinVacances>= ".$ShiftDay.")";

    $MainOutput->inputhidden_env('IDInstallation',$Info['IDInstallation']);
	$MainOutput->inputhidden_env('Update',TRUE);
	$MainOutput->inputhidden_env('IDShift',$_GET['IDShift']);
    $employe_list = $employeeService->getEmployeSelectList(new DateTime("@".$ShiftDay));
}else{
    $MainOutput->inputhidden_env('Update',FALSE);
    $Info = array('Salaire'=>'','IDEmploye'=>'','TXH'=>'','Jour'=>'','Start'=>'','End'=>'','Commentaire'=>'','Warn'=>'','Message'=>'','Assistant'=>'0','Confirme'=>0);
    $employe_list = $employeeService->getEmployeSelectList();
}
$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
$MainOutput->inputselect('Jour',$CJour,$Info['Jour'],'Jour');
$MainOutput->inputtime('Start','Début',$Info['Start']);
$MainOutput->inputtime('End','Fin',$Info['End']);
$MainOutput->flag('Assistant',$Info['Assistant']);


# Il doit avoir un 60h � mettre pour g�rer la logique des shift, et des staffs.



$MainOutput->inputselect('IDEmploye',$employe_list,$Info['IDEmploye'],'Sauveteur');

$MainOutput->inputtext('Salaire','Salaire',4,$Info['Salaire']);


if($authorization->verifySuperAdmin($_COOKIE)){
    $MainOutput->inputtext('TXH','Taux Horaire',4,$Info['TXH']);
}else{
    $MainOutput->inputhidden('TXH',$Info['TXH']);
}

$MainOutput->textarea('Commentaire','Commentaire','25','2',$Info['Commentaire']);
$MainOutput->inputtext('Rec','Nb de récurrences','2');
if($Section=="Shift_Form"){
    $MainOutput->textarea('Message','Message','25','2',$Info['Message']);
	$MainOutput->textarea('Warn','Pré-shit','25','2',$Info['Warn']);
	$MainOutput->flag('Confirme',$Info['Confirme'],'Heures Confirmées');
	}
$MainOutput->flag('Attach',1,'Attacher les shiftFormatter');


$MainOutput->formsubmit('Ajouter / Modifier');
echo $MainOutput->send(1);
?>