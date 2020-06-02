<?PHP
$MainOutput->addform('Copier l\'horaire officiel vers l\'horaire réel');
	$MainOutput->inputhidden_env('Action','Shift');

$Piscine ="SELECT installation.IDInstallation, installation.Nom
FROM horaire
JOIN installation
JOIN horshift ON installation.IDHoraire = horaire.IDHoraire
AND horshift.IDHoraire = horaire.IDHoraire
WHERE Saison
GROUP BY horaire.IDHoraire
ORDER BY IDClient ASC, installation.Nom ASC";
$MainOutput->flaglist('IDInstallation',$Piscine,array(),'Horaire à copier');
$MainOutput->inputtime('FROM','Commençant','',array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->inputtime('TO','Terminant','',array('Date'=>TRUE,'Time'=>FALSE));

$MainOutput->formsubmit('Copier l\'horaire');
echo $MainOutput->send(1);

?>
