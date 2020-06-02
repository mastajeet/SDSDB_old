<?PHP
$MainOutput->AddForm('Boni Crusher');
$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE !Cessation ORDER BY Nom ASC, Prenom ASC";
$MainOutput->InputSelect('IDEmploye',$Req,'','Employé');
$MainOutput->InputHidden_Env('Action','BoniCrusher');

$Raison = array(
'Retard'=>'Retard',
'Absence'=>'Absence',
'Remplacement dernière minute'=>'Remplacement dernière minute',
'Pas de spécimen de chèque'=>'Pas de spécimen de chèque',
'Pas donné ses heures'=>'Pas donné ses heures',
'Pas retourné après la pluie'=>'Pas retourné après la pluie',
'Pas de spécimen de chèque'=>'Pas de spécimen de chèque',
'Départ injustifié'=>'Départ injustifié',
'Problème à l\'éthique'=>'Problème à l\'éthique',
'Non Respect de son horaire'=>'Non Respect de son horaire');

$MainOutput->inputtime('Date','Date','',array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->InputSelect('Raison',$Raison);
$MainOutput->InputText('Detail');
$MainOutput->InputText('Pourcentage','Pourcentage',3);
$MainOutput->FormSubmit('CRUSHHH!!!!');
echo $MainOutput->Send(1);
?>