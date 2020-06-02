<?PHP
$SQL = new sqlclass();
$SQL2 = new sqlclass();
$SQL3 = new sqlclass();


$Req = "SELECT IDConfirmation FROM confirmation WHERE IDEmploye= ".$_COOKIE['IDEmploye']." AND Semaine=".$_POST['Semaine'];
$SQL->SELECT($Req);
$NB = $SQL->NumRow();
$String = "";
$Time = time();
$Today = date('w',$Time);
$TW = get_last_sunday();
if($TW<>$_POST['Semaine'])
	$Today = 8;
	
$RN = $Today*24*60*60+intval(date('H',$Time))*60*60+intval(date('i',$Time)*60);
if($NB==0){
	$Req2 = "INSERT INTO confirmation(`IDEmploye`,`Semaine`,`Notes`) VALUES('".$_COOKIE['IDEmploye']."','".$_POST['Semaine']."','".addslashes($_POST['FORMNotes'])."')";
	$SQL2->INSERT($Req2);
	$IDConfirmation = get_last_id('confirmation');	
}else{
	$Rep = $SQL->FetchArray();
	$IDConfirmation = $Rep[0];	
	$Req2 = "UPDATE confirmation SET `Notes` = '".addslashes($_POST['FORMNotes'])."' WHERE IDConfirmation = ".$IDConfirmation;
	$SQL2->QUERY($Req2);
}
$Req = "SELECT IDShift, Jour*24*3600+End as A FROM shift WHERE Semaine='".$_POST['Semaine']."' && IDEmploye='".$_POST['IDEmploye']."' && `EmpConf`=0  && `Confirme`=0 && Jour*24*3600+End<=".$RN;
$SQL->Select($Req);
while($Rep = $SQL->FetchArray()){
$String .= ",".$Rep[0];
	if(!stristr($_POST['Sh'.$Rep[0]],'h'))
		$Start = $_POST['Sh'.$Rep[0]]*3600;
	else{
		$Right = stristr($_POST['Sh'.$Rep[0]],'h');
		$Len = strlen($Right);
		$Minute = round(intval(substr($Right,1)),2);
		$Hrs = substr($_POST['Sh'.$Rep[0]],0,-$Len);
		$Start = $Hrs*3600 + $Minute*60;
	}
	if(!stristr($_POST['Eh'.$Rep[0]],'h'))
		$End = $_POST['Eh'.$Rep[0]]*3600;
	else{
		$Right = stristr($_POST['Eh'.$Rep[0]],'h');
		$Len = strlen($Right);
		$Minute = round(intval(substr($Right,1)),2);
		$Hrs = substr($_POST['Eh'.$Rep[0]],0,-$Len);
		$End = $Hrs*3600 + $Minute*60;
	}
	$Req2 = "INSERT INTO confshift(`IDShift`,`Start`,`End`,`IDConfirmation`) VALUES('".$Rep[0]."','".$Start."','".$End."','".$IDConfirmation."')";
	$SQL2->Query($Req2);
}
	$Req2 = "UPDATE shift set EmpConf=1 WHERE IDShift in (".substr($String,1).")";
	$SQL2->Query($Req2);
$_REQUEST['Section'] = "Confirm_Heures";
?>