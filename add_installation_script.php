<?PHP
$SQL = new SQLclass();
if(!isset($_POST['FORMPunch'])){
	$_POST['FORMPunch']=0;
}
if(!isset($_POST['FORMActif'])){
	$_POST['FORMActif']=0;
}
if(!isset($_POST['FORMCadenas'])){
	$_POST['FORMCadenas']=0;
}
if(!isset($_POST['FORMAssistant'])){
	$_POST['FORMAssistant']=0;
}
if($_POST['FORMAdresse']==""){
	$Req = "SELECT Adresse FROM client WHERE IDClient = '".$_POST['FORMIDClient']."'";
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	$_POST['FORMAdresse'] = $Rep['Adresse'];
}
if($_POST['FORMTel2']==""){
	$Req = "SELECT Tel FROM client WHERE IDClient = '".$_POST['FORMIDClient']."'";
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	$FullTel = $Rep['Tel'];
}
if($_POST['FORMCote']==""){
	$Req = "SELECT Cote FROM client WHERE IDClient = '".$_POST['FORMIDClient']."'";
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	$_POST['FORMCote'] = $Rep['Cote'];
}
if($_POST['FORMNom']==""){
	$Req = "SELECT Nom FROM client WHERE IDClient = '".$_POST['FORMIDClient']."'";
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	$_POST['FORMNom'] = $Rep['Nom'];
}

$FullTel = $_POST['FORMTel1'].$_POST['FORMTel2'].$_POST['FORMTel3'].$_POST['FORMTel4'];

$Req = "INSERT INTO installation(`IDClient`,`IDResponsable`,`Nom`,`Tel`,`Adresse`,`IDSecteur`,`Lien`,`Cote`,`Notes`,`Actif`,`Punch`,`IDType`,`Toilettes`,`Cadenas`,`Assistant`) VALUES
(
'".$_POST['FORMIDClient']."',
'".$_POST['FORMIDResponsable']."',
'".addslashes($_POST['FORMNom'])."',
'".$FullTel."',
'".addslashes($_POST['FORMAdresse'])."',
'".$_POST['FORMIDSecteur']."',
'".$_POST['FORMLien']."',
'".$_POST['FORMCote']."',
'".addslashes($_POST['FORMNotes'])."',
'".$_POST['FORMActif']."',
'".$_POST['FORMPunch']."',
'".$_POST['FORMIDType']."',
'".$_POST['FORMToilettes']."',
'".$_POST['FORMCadenas']."',
'".$_POST['FORMAssistant']."'
)";
$_POST['IDInstallation'] = get_last_id('installation');
$SQL->insert($Req);
?>