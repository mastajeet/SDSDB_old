<?PHP
$MainOutput->OpenTable('400');
$MainOutput->OpenRow();
$MainOutput->OpenCol();
	$MainOutput->AddForm('Ajouter un accès employé');
    $MainOutput->InputText('NoEmployee','Numéro Employé',10);
    $MainOutput->InputText('NAS','NAS',9);
	$MainOutput->InputHidden_env('Section','SuperAdmin');
	$MainOutput->InputHidden_env('Action','createEmployeeAccess');
	$MainOutput->FormSubmit('Créer un accès');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->CloseTable();
echo $MainOutput->Send(1);
?>