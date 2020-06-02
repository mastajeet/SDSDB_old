<?PHP

$SQL = new sqlclass;
$SQL2 = new sqlclass;

$Req = "SELECT IDShift FROM confshift WHERE IDConfirmation=".$_POST['IDConfirmation'];
$SQL->Select($Req);
while($Rep = $SQL->FetchArray()){


	$Start = $_POST['Sh'.$Rep[0]]*3600;
	$End = $_POST['Eh'.$Rep[0]]*3600;
	
	if($Start==$End)
		$Req2 = "DELETE FROM shift WHERE IDShift = '".$Rep[0]."'";
	else
		$Req2 = "UPDATE shift set Start='".$Start."', Confirme='1', End='".$End."' WHERE IDShift = '".$Rep[0]."'";
	
	$SQL2->Query($Req2);

}

	$Req2 = "UPDATE confirmation set Confirme=1 WHERE IDConfirmation =".$_POST['IDConfirmation'];
	$SQL2->Query($Req2);


$_GET['Section'] = 'Conf_Shift';
$_GET['Semaine'] = $_POST['Semaine'];

?>