<?PHP
$SQL = new sqlclass;
$IDPaye = $_POST['IDPaye'];
if($_POST['FORMArgent']<>""){
	$Req = "SELECT IDTimesheet FROM timesheet WHERE IDEmploye = '".$_POST['FORMIDEmploye']."' && Heures=0 && IDPaye=".$IDPaye;
	$SQL->SELECT($Req);
	$NB = $SQL->NumRow();
	if($NB==0){
		$Req = "INSERT INTO timesheet(`IDEmploye`,`Salaire`,`Heures`,`IDPaye`,`Ajustement`) VALUES('".$_POST['FORMIDEmploye']."','".$_POST['FORMArgent']."','0','".$IDPaye."',1)";
	}else{
		$Rep = $SQL->FetchArray();
		$Req = "UPDATE timesheet set Salaire = Salaire +'".$_POST['FORMArgent']."' WHERE IDTimesheet = '".$Rep[0]."'";
	}	
	$SQL->QUERY($Req);
}if($_POST['FORMNBH']){

	if($_POST['FORMTaux']=='Autre' || $_POST['FORMTX']<>""){
		$Salaire = $_POST['FORMTX'];
	}else{
		$Req = "SELECT `".$_POST['FORMTaux']."` FROM employe WHERE IDEmploye = '".$_POST['FORMIDEmploye']."'";
		$SQL->SELECT($Req);
		$Rep = $SQL->FetchArray();
		$Salaire = $Rep[0];
	}
		$Req = "SELECT IDTimesheet, Ajustement FROM timesheet WHERE IDEmploye = '".$_POST['FORMIDEmploye']."' && abs(Salaire-".floatval($Salaire).")<0.01 && Heures=1 && `IDPaye`=".$IDPaye;
		$SQL->SELECT($Req);
		$NB = $SQL->NumRow();
	if($NB==0){
		$Req = "INSERT INTO timesheet(`IDEmploye`,`Salaire`,`Ajustement`,`Heures`,`IDPaye`) VALUES('".$_POST['FORMIDEmploye']."','".$Salaire."','".$_POST['FORMNBH']."','1','".$IDPaye."')";
	}else{
		$Rep = $SQL->FetchArray();
		$Req = "UPDATE timesheet set Ajustement = Ajustement +".$_POST['FORMNBH']." WHERE IDTimesheet = '".$Rep[0]."'";
	}
	$SQL->QUERY($Req);
}

$_GET['Section'] = 'Display_Timesheet';
$_GET['FORMIDPaye']=$IDPaye;
?>