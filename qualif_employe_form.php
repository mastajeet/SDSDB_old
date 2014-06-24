<?PHP
$MainOutput->AddForm('Ajouter une qualification');
$MainOutput->inputhidden_env('Action','Add_Qualif');
$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE Engage && !Cessation ORDER BY Nom ASC";
$MainOutput->InputSelect('IDEmploye',$Req,'','Nom');

$Req = "SELECT IDQualification, Full FROM qualification ORDER BY Full ASC";
$MainOutput->InputSelect('IDQualification',$Req,'','Qualification');

$MainOutput->OpenRow();
$MainOutput->OpenCol();
$MainOutput->AddTexte('Expiration','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol();
$MainOutput->AddOutput('<input type=text size=2 name=FORMMonth> / <input type=text size=4 name=FORMAnnee>',0,0);
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->Formsubmit('Ajouter');
echo $MainOutput->Send(1);
?>