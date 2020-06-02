<?PHP
$SQL = new SQLclass();
if(!isset($_POST['FORMCessation'])){
	$_POST['FORMCessation']=0;
}
if($_POST['FORMIDEmploye']==""){
	$_POST['FORMIDEmploye']=get_last_id('employe')+1;
}
$Naissance = mktime(0,0,0,$_POST['FORMDateNaissance4'],$_POST['FORMDateNaissance5'],$_POST['FORMDateNaissance3']);
$Embauche = mktime(0,0,0,$_POST['FORMDateEmbauche4'],$_POST['FORMDateEmbauche5'],$_POST['FORMDateEmbauche3']);

$Req = 
"INSERT INTO employe
(`IDEmploye`,`Nom`,`Prenom`,`HName`,`NAS`,`Session`,`DateNaissance`,`Adresse`,`CodePostal`,`Email`,`TelP`,`TelA`,`Cell`,`Paget`,
`IDSecteur`,`Ville`,`Status`,`Cessation`,`Notes`,`Raison`,`SalaireB`,`SalaireS`,`SalaireA`,`DateEmbauche`) 
VALUES (
'".$_POST['FORMIDEmploye']."',
'".addslashes($_POST['FORMNom'])."',
'".addslashes($_POST['FORMPrenom'])."',
'".addslashes($_POST['FORMHName'])."',
'".$_POST['FORMNAS']."',
'".$_POST['FORMSession']."',
'".$Naissance."',
'".addslashes($_POST['FORMAdresse'])."',
'".$_POST['FORMCodePostal']."',
'".$_POST['FORMEmail']."',
'".$_POST['FORMTelP1'].$_POST['FORMTelP2'].$_POST['FORMTelP3']."',
'".$_POST['FORMTelA1'].$_POST['FORMTelA2'].$_POST['FORMTelA3']."',
'".$_POST['FORMCell1'].$_POST['FORMCell2'].$_POST['FORMCell3']."',
'".$_POST['FORMPaget1'].$_POST['FORMPaget2'].$_POST['FORMPaget3']."',
'".$_POST['FORMIDSecteur']."',
'".addslashes($_POST['FORMVille'])."',
'".$_POST['FORMStatus']."',
'".$_POST['FORMCessation']."',
'".addslashes($_POST['FORMNotes'])."',
'".addslashes($_POST['FORMRaison'])."',
'".$_POST['FORMSalaireB']."',
'".$_POST['FORMSalaireS']."',
'".$_POST['FORMSalaireA']."',
'".$Embauche."')";
$SQL->insert($Req);
?>