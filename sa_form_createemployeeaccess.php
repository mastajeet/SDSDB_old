<?PHP
$MainOutput->OpenTable('400');
$MainOutput->OpenRow();
$MainOutput->OpenCol();
	$MainOutput->AddForm('Ajouter un acc�s employ�');
    $MainOutput->InputText('NoEmployee','Num�ro Employ�',10);
    $MainOutput->InputText('NAS','NAS',9);
	$MainOutput->InputHidden_env('Section','SuperAdmin');
	$MainOutput->InputHidden_env('Action','createEmployeeAccess');
	$MainOutput->FormSubmit('Cr�er un acc�s');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->CloseTable();
echo $MainOutput->Send(1);
?>