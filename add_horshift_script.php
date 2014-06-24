<?PHP	
$SQL = new sqlclass();
if(!isset($_POST['FORMAssistant']))
	$_POST['FORMAssistant']=0;
	

$Start = 60*($_POST['FORMStart1']+60*$_POST['FORMStart2']);
$End = 60*($_POST['FORMEnd1']+60*$_POST['FORMEnd2']);

$Req = "SELECT End, Start, Assistant FROM horshift WHERE IDHoraire = '".$_POST['IDHoraire']."' && Jour='".$_POST['FORMJour']."' ORDER BY Start ASC";
$INSERT = TRUE;
$SQL->SELECT($Req);
	
	if($End<$Start)
		$INSERT=FALSE;	
	


while($Rep = $SQL->FetchArray()){


if($_POST['FORMAssistant']==0){

	$Start = intval($Start);
	$End = intval($End);
	$SStart = intval($Rep['Start']);
	$SEnd = intval($Rep['End']);
		
		if($End>$SStart && $End<$SEnd)
			$End=$SStart;
		if($Start<$SEnd && $Start>$SStart)
			$Start=$SEnd;
		if($Rep['Start']== $Start)
			$INSERT = FALSE;
		if($Rep['End']== $End)
			$INSERT = FALSE;
	}

}


	

$Req = "INSERT INTO horshift(`Jour`,`Start`,`End`,`Assistant`,`Commentaire`,`TXH`,`Salaire`,`IDHoraire`,`IDEmploye`) 

VALUES(
'".$_POST['FORMJour']."',
'".$Start."',
'".$End."',
'".$_POST['FORMAssistant']."',
'".addslashes($_POST['FORMCommentaire'])."',
'".$_POST['FORMTXH']."',
'".$_POST['FORMSalaire']."',
'".$_POST['IDHoraire']."',
'".$_POST['FORMIDEmploye']."')";


if($INSERT)
	$SQL->insert($Req);
?>