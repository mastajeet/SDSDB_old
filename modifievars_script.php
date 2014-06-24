<?PHP
	$Req = "UPDATE vars SET `Valeur`='".$_POST['FORMValue']."' WHERE `Nom`='".$_POST['Vars']."'";
	$SQL->Update($Req);
?>