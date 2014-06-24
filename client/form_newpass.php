<?PHP

$MainOutput->AddForm('Changement de mot de passe');
$MainOutput->inputHidden_env('Action','Modifier_Password');
$MainOutput->inputPassword('OLDPW','Ancient&nbsp;mot&nbsp;de&nbsp;passe');
$MainOutput->inputPassword('NEWPW','Nouveau&nbsp;mot&nbsp;de&nbsp;passe');
$MainOutput->inputPassword('NEWPWC','Confirmer&nbsp;le&nbsp;mot&nbsp;de&nbsp;passe');
$MainOutput->formSubmit('Modifier');

?>
