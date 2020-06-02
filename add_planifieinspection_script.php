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

if($_POST['FORMIDEmploye']==" ")
	$_POST['FORMIDEmploye']="NULL";

	
if($_POST['FORMIDResponsable']==" ")
	$_POST['FORMIDEmploye']="NULL";

$Req = "SELECT IDInspection FROM inspection WHERE IDInstallation=".$_POST['IDInstallation']." AND Annee=".get_vars('Boniyear');
$SQL->select($Req);
if($SQL->NumRow()>0){
//$WarnOutput->AddTexte('Il Existe déjà une inspection pour cette année et cette installation','Warning');
}else{	
$Req = "INSERT INTO inspection(`IDInstallation`,`IDResponsable`,`IDEmploye`,`DateR`,`DateP`,`Annee`) VALUES('".$_POST['IDInstallation']."',".$_POST['FORMIDResponsable'].",".$_POST['FORMIDEmploye'].",".$DateR.",".$Date.",'".get_vars('Boniyear')."')";

$SQL->INSERT($Req);

//$WarnOutput->AddTexte('Inspection planifiée','Warning');
}

?>