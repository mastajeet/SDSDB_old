<?PHP
$MainOutput->AddForm('Ajouter un remplacement');
$MainOutput->inputhidden_env('Action','Add_Remplacement');

$MainOutput->InputSelect('IDEmployeS',$employeeList,'','Employ� Sortant');
$MainOutput->inputtime('FROM','Commen�ant','',array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->inputtime('TO','Terminant','',array('Date'=>TRUE,'Time'=>FALSE));

$MainOutput->textarea('Raison',NULL,25,1);
$MainOutput->flag('Lastminute',0,'Derni�re Minute');
$MainOutput->flag('Email',1,'Confirmation Email');


$MainOutput->InputSelect('Talkedto',$employeeList,'','Demand� �');


$MainOutput->Formsubmit('Ajouter');
echo $MainOutput->Send(1);
?>