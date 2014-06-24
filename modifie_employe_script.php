<?PHP
$SQL = new SQLclass();
if(!isset($_POST['FORMEngage'])){
	$_POST['FORMEngage']=0;
}
if(!isset($_POST['FORMCessation'])){
	$_POST['FORMCessation']=0;
}
if($_POST['FORMDateNaissance5']<>0)
	$Naissance = mktime(0,0,0,$_POST['FORMDateNaissance4'],$_POST['FORMDateNaissance5'],$_POST['FORMDateNaissance3']);
else
	$Naissance = '';
if($_POST['FORMDateEmbauche5']<>0)
	$Embauche = mktime(0,0,0,$_POST['FORMDateEmbauche4'],$_POST['FORMDateEmbauche5'],$_POST['FORMDateEmbauche3']);
else
	$Embauche='';

$Req = "UPDATE employe SET

`Nom` = '".addslashes($_POST['FORMNom'])."',
`Prenom` = '".addslashes($_POST['FORMPrenom'])."',
`HName` = '".addslashes($_POST['FORMHName'])."',
`NAS` = '".$_POST['FORMNAS']."',
`Session` = '".$_POST['FORMSession']."',
`DateNaissance` = '".$Naissance."',
`Adresse` = '".addslashes($_POST['FORMAdresse'])."',
`Ville` = '".addslashes($_POST['FORMVille'])."',
`CodePostal` = '".$_POST['FORMCodePostal']."',
`Email` = '".$_POST['FORMEmail']."',
`TelP` = '".$_POST['FORMTelP1'].$_POST['FORMTelP2'].$_POST['FORMTelP3']."',
`TelA` = '".$_POST['FORMTelA1'].$_POST['FORMTelA2'].$_POST['FORMTelA3']."',
`Cell` = '".$_POST['FORMCell1'].$_POST['FORMCell2'].$_POST['FORMCell3']."',
`Paget` = '".$_POST['FORMPaget1'].$_POST['FORMPaget2'].$_POST['FORMPaget3']."',
`IDSecteur` = '".$_POST['FORMIDSecteur']."',
`Status` = '".$_POST['FORMStatus']."',
`Cessation` = '".$_POST['FORMCessation']."',
`Engage` = 1,
`Notes` = '".addslashes($_POST['FORMNotes'])."',
`Raison` = '".addslashes($_POST['FORMRaison'])."',
`SalaireB` = '".$_POST['FORMSalaireB']."',
`SalaireS` = '".$_POST['FORMSalaireS']."',
`SalaireA` = '".$_POST['FORMSalaireA']."',
`EAssistant` = '".$_POST['FORMEmploi']."',
`DateEmbauche` = '".$Embauche."' 
WHERE IDEmploye = '".$_POST['IDEmploye']."'";
$SQL->insert($Req);


$Section = 'EmployeList';//$_POST['Section'];
$_GET['Session']=$_POST['FORMSession'];
if($_GET['Session']==" ")
	$_GET['Session']="";
$_GET['Assistant']=$_POST['FORMEmploi'];
if($_GET['Assistant'])
	$_GET['Session']="%";
?>