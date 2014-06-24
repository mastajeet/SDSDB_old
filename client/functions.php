<?PHP
function get_employe_list($IDClient){
	$SQL = new sqlclass;
	$InsList= get_installation_list($IDClient);
	$Req = "SELECT DISTINCT employe.IDEmploye, employe.Nom, employe.Prenom FROM employe JOIN shift on shift.IDEmploye = employe.IDEmploye WHERE shift.IDInstallation in (".$InsList.") AND employe.IDEmploye <> 0 ORDER BY employe.Nom ASC, employe.Prenom ASC";
	$SQL->SELECT($Req);
	$RetArray = array();
	while($Rep = $SQL->FetchArraY()){
		$RetArray[$Rep[0]] = $Rep[1]." ".$Rep[2];
	}
	return $RetArray;
}

function get_installation_list($IDClient,$Return="STRING"){
	$SQL = new sqlclass;
	$Req = "SELECT IDInstallation, Nom FROM installation WHERE IDClient = ".$IDClient." ORDER BY Nom ASC";
	$SQL->SELECT($Req);
	$str = "";
	$arr = "";
	while($Rep = $SQL->FetchArray()){
		$str .= ",".$Rep[0];
		$arr[$Rep[0]] = $Rep[1];
	}
	if($Return=="STRING")
		return substr($str,1);
	if($Return=="ARRAY")
		return $arr;
	else
		die("Erreur Veuillez spécifier une variable de retour valide");
}

function get_responsable_list($IDClient){
	$SQL = new sqlclass;
	$Req = "(SELECT RespF as A, responsable.Nom as B, responsable.Prenom as C from client JOIN responsable on responsable.IDResponsable = client.RespF WHERE IDClient = ".$IDClient.") 
			UNION
			(SELECT RespP as A, responsable.Nom as B, responsable.Prenom as C from client JOIN responsable on responsable.IDResponsable = client.RespF WHERE IDClient = ".$IDClient.") 
			UNION
			(SELECT responsable.IDResponsable as A, responsable.Nom as B, responsable.Prenom as C from installation JOIN responsable on responsable.IDResponsable = installation.IDResponsable WHERE IDClient = ".$IDClient.") 
			ORDER BY B ASC, C ASC";
	$SQL->SELECT($Req);
	$retArray = "";
	while($Rep = $SQL->FetchArray()){
		$retArray[$Rep['A']] = $Rep['B']." ".$Rep['C'];
	}
	return $retArray;
}


function trouver_shift($IDInstallation, $Date){
	$SQL = new SQLclass();
	//Date as timestamp
	$Date = getdate($Date);
	$Semaine = get_last_sunday(0,mktime(0,0,0,$Date['mon'],$Date['mday'],$Date['year']));
	$Req = "SELECT IDShift, Start from shift where Semaine= ".$Semaine." and Jour=".$Date['wday']." and IDInstallation=".$IDInstallation." order by Start ASC";
	$SQL->SELECT($Req);
	$HeureCible =  ($Date['hours']*60+$Date['minutes'])*60+$Date['seconds'];
	$IDShiftCible = 0;
	while($Rep = $SQL->FetchArray()){
		if($Rep['Start']<=$HeureCible)
			$IDShiftCible = $Rep['IDShift'];
	}
	if($IDShiftCible ==0)
		die("Aucun shift n'a été trouvé");
	return $IDShiftCible;
}

function get_client_info($IDClient){
	$SQL = new SQLclass();
	$Req = "SELECT * FROM client WHERE IDClient = ".$IDClient;
	$SQL->SELECT($Req);
	return $SQL->FetchArray();
}