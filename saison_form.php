<?PHP
$MainOutput->AddForm('Ajouter une saison');
$MainOutput->inputhidden_env('Action','Saison');
$MainOutput->InputText('Saison','Saison','1');
$MainOutput->InputText('Annee','Année','2',date('y',time()));
$MainOutput->FormSubmit('Ajouter');
echo $MainOutput->send(1);
?>