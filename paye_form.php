<?PHP

$MainOutput->addform('Ajouter une période de paye');
$MainOutput->inputhidden_env('Action','Paye');
$MainOutput->inputtime('Finissant','Paye finissant le','0',array('Time'=>FALSE,'Date'=>TRUE));
$SQL = new sqlclass;
$Req = "SELECT No FROM paye ORDER BY IDPaye DESC LIMIT 0,1";
$SQL->Select($Req);
$Rep = $SQL->FetchArray();
if($Rep[0]<>26){
	$No = $Rep[0]+1;
}else{
	$No = 1;
}
$MainOutput->inputtext('No','Numéro de paye',1,$No);
$MainOutput->formsubmit('Ajouter');
echo $MainOutput->send(1);
?>