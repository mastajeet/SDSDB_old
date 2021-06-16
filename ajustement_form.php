<?PHP
if(!isset($_GET['IDEmploye'])){
	$_GET['IDEmploye']=0;
}

$MainOutput->AddForm('Ajouter un Ajustement');
$MainOutput->inputhidden_env('Action','Ajustement');
$MainOutput->inputhidden_env('IDPaye',$_GET['IDPaye']);

$MainOutput->InputSelect('IDEmploye',$employeeService->getEmployeSelectList(),$_GET['IDEmploye'],'Employé');
$MainOutput->InputText('NBH','Nombre d\'heures',2,0);
$Tx = array('SalaireS'=>'Sauveteur','SalaireA'=>'Assistant','SalaireB'=>'Bureau','Autre'=>'Autre');
$MainOutput->InputSelect('Taux',$Tx,'SalaireS');
$MainOutput->InputText('TX','Taux autre (h)',4);
$MainOutput->InputText('Argent','Ajustement&nbsp;Argent&nbsp;($)',4);
$MainOutput->FormSubmit();
echo $MainOutput->send(1);
?>