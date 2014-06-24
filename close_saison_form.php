<?PHP

$MainOutput->AddForm('Fermer une saison');
$Opt = get_saison_list();
$MainOutput->inputhidden_env('Action','Saison');
$MainOutput->InputSelect('IDSaison',$Opt,'','Saison');
$MainOutput->FormSubmit('Fermer');
echo $MainOutput->send(1);

?>