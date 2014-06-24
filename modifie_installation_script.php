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

$Req = "UPDATE installation SET 
`IDResponsable`='".$_POST['FORMIDResponsable']."',
`Nom`='".addslashes($_POST['FORMNom'])."',
`Tel`='".$FullTel."',
`Adresse`='".addslashes($_POST['FORMAdresse'])."',
`IDSecteur`='".$_POST['FORMIDSecteur']."',
`Lien`='".$_POST['FORMLien']."',
`Cote`='".$_POST['FORMCote']."',
`Notes`='".addslashes($_POST['FORMNotes'])."',
`Actif`='".$_POST['FORMActif']."',
`Punch`='".$_POST['FORMPunch']."',
`IDType`='".$_POST['FORMIDType']."',
`Toilettes`='".addslashes($_POST['FORMToilettes'])."',
`Cadenas`='".$_POST['FORMCadenas']."',
`Assistant`='".$_POST['FORMAssistant']."'
WHERE IDInstallation = '".$_POST['IDInstallation']."'";

$SQL->update($Req);
$_GET['Section'] = "Display_Client";

?>