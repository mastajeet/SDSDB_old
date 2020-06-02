<?PHP

$number = cal_days_in_month(CAL_GREGORIAN, $_POST['FORMMonth'], $_POST['FORMAnnee']);
$Time = mktime(0,0,0,$_POST['FORMMonth'],$number,$_POST['FORMAnnee']);

$SQL = new sqlclass;

if($_POST['FORMIDQualification']==2){
	$Req = "DELETE FROM link_employe_qualification WHERE IDQualification=1 AND IDEmploye=".$_POST['FORMIDEmploye'];
	$SQL->QUERY($Req);
}
if($_POST['FORMIDQualification']==3 || $_POST['FORMIDQualification']==4){
	$Req = "DELETE FROM link_employe_qualification WHERE IDQualification=1 AND IDEmploye=".$_POST['FORMIDEmploye'];
	$SQL->QUERY($Req);
	$Req = "DELETE FROM link_employe_qualification WHERE IDQualification=2 AND IDEmploye=".$_POST['FORMIDEmploye'];
	$SQL->QUERY($Req);
}
if($_POST['FORMIDQualification']==6){
	$Req = "DELETE FROM link_employe_qualification WHERE IDQualification=5 AND IDEmploye=".$_POST['FORMIDEmploye'];
	$SQL->QUERY($Req);
}

//CHECK POUR REQUAL
	$Req = "DELETE FROM link_employe_qualification WHERE IDQualification=".$_POST['FORMIDQualification']." AND IDEmploye=".$_POST['FORMIDEmploye'];
	$SQL->QUERY($Req);



$Req = "INSERT INTO link_employe_qualification(`IDEmploye`,`IDQualification`,`Expiration`) VALUES('".$_POST['FORMIDEmploye']."','".$_POST['FORMIDQualification']."','".$Time."') ";

$SQL->INSERT($Req);
$_GET['Section'] = "Add_Qualif";
$MainOutput->AddTexte('Qualification Ajout�e','Warning');
$MainOutput->br();
?>