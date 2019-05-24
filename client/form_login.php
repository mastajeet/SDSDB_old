<?PHP
$MainOutput->br(2);
$MainOutput->AddForm('Veuillez entrer vos identifiants');
$MainOutput->inputHidden_env('Action','Login');

$MainOutput->InputSelect('CIE',array('QC'=>'Québec','MTL'=>'Montréal','TR'=>'Trois-Rivières'),'QC','Région');
$MainOutput->inputText('Cote','Cote&nbsp;de&nbsp;Facturation',5);
$MainOutput->InputPassword('Password','Mot de passe');
$MainOutput->FormSubmit('Connexion');
echo $MainOutput->Send(1);
?>