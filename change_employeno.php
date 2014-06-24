<?PHP
	$SQL = new sqlclass();
	$Req = "UPDATE employe SET IDEmploye = ".$_POST['FORMIDEmployeFin']." WHERE IDEmploye = ".$_POST['FORMIDEmployeIni'];
	
	$SQL->QUERY($Req);
	$Req = "UPDATE shift SET IDEmploye = ".$_POST['FORMIDEmployeFin']." WHERE IDEmploye = ".$_POST['FORMIDEmployeIni'];

	$SQL->QUERY($Req);
	$Req = "UPDATE shiftbck SET IDEmploye = ".$_POST['FORMIDEmployeFin']." WHERE IDEmploye = ".$_POST['FORMIDEmployeIni'];

	$SQL->QUERY($Req);
	$Req = "UPDATE bonicrusher SET IDEmploye = ".$_POST['FORMIDEmployeFin']." WHERE IDEmploye = ".$_POST['FORMIDEmployeIni'];

	$SQL->QUERY($Req);
	$Req = "UPDATE commentaire SET IDEmploye = ".$_POST['FORMIDEmployeFin']." WHERE IDEmploye = ".$_POST['FORMIDEmployeIni'];

	$SQL->QUERY($Req);
	$Req = "UPDATE confirmation SET IDEmploye = ".$_POST['FORMIDEmployeFin']." WHERE IDEmploye = ".$_POST['FORMIDEmployeIni'];

	$SQL->QUERY($Req);
	$Req = "UPDATE inspection SET IDEmploye = ".$_POST['FORMIDEmployeFin']." WHERE IDEmploye = ".$_POST['FORMIDEmployeIni'];

	$SQL->QUERY($Req);
	$Req = "UPDATE link_employe_qualification SET IDEmploye = ".$_POST['FORMIDEmployeFin']." WHERE IDEmploye = ".$_POST['FORMIDEmployeIni'];

	$SQL->QUERY($Req);
	$Req = "UPDATE message SET IDEmploye = ".$_POST['FORMIDEmployeFin']." WHERE IDEmploye = ".$_POST['FORMIDEmployeIni'];

	$SQL->QUERY($Req);
	$Req = "UPDATE remplacement SET IDEmployeS = ".$_POST['FORMIDEmployeFin']." WHERE IDEmployeS = ".$_POST['FORMIDEmployeIni'];

	$SQL->QUERY($Req);

	$Req = "UPDATE remplacement SET IDEmployeE = ".$_POST['FORMIDEmployeFin']." WHERE IDEmployeE = ".$_POST['FORMIDEmployeIni'];

	$SQL->QUERY($Req);
	$Req = "UPDATE timesheet SET IDEmploye = ".$_POST['FORMIDEmployeFin']." WHERE IDEmploye = ".$_POST['FORMIDEmployeIni'];
	$SQL->QUERY($Req);

?>
