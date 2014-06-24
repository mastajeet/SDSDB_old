<?PHP
$MainOutput->AddForm('Modifier une facture - Cote et Séquence');
$MainOutput->InputHidden_env('Action','Modifie_Facture_CoteSeq');
$MainOutput->InputText('Initial','Cote-Seq initial','6');
$MainOutput->InputText('Final','Cote-Seq à mettre','6');
$MainOutput->FormSubmit('Modifier');
?>