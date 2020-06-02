<?PHP
$MainOutput->AddForm('Rechercher une date');
$MainOutput->inputhidden_env('Action','Date_Lookup');
$MainOutput->InputTime('Date','','',array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->FormSubmit('Rechercher');
echo $MainOutput->send(1);
?>