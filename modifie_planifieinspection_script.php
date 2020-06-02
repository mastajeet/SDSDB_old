<?PHP

if($_POST['FORMDateP5']<>""){
	$Date = mktime($_POST['FORMDateP2'],$_POST['FORMDateP1'],0,$_POST['FORMDateP4'],$_POST['FORMDateP5'],$_POST['FORMDateP3']);
}else{
	$Date = "NULL";
}

if($_POST['FORMDateR5']<>""){
	$DateR = mktime(0,0,0,$_POST['FORMDateR4'],$_POST['FORMDateR5'],$_POST['FORMDateR3']);
}else{
	$DateR = "NULL";
}


$Req = "UPDATE inspection SET IDResponsable=".$_POST['FORMIDResponsable'].",IDEmploye=".$_POST['FORMIDEmploye'].", DateP=".$Date.", DateR=".$DateR." WHERE IDInspection=".$_POST['IDInspection'];
$SQL->QUERY($Req);

?>