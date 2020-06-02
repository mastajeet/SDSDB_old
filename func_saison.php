<?PHP

function add_saison($Saison,$Annee){
	$SQL = new sqlclass;
	$Req = "INSERT INTO saison(`Saison`,`Annee`) VALUES('".$Saison."','".$Annee."')";
	$SQL->INSERT($Req);
}

function close_saison($IDSaison){
	$SQL = new sqlclass;
	$Req = "UPDATE saison SET `Actif` = 0 WHERE IDSaison = ".$IDSaison;
	$SQL->QUERY($Req);
	$Info = get_saison_info($IDSaison);
	$Req = "UPDATE employe SET `Session` = '' WHERE Session = '".$Info['Saison'].$Info['Annee']."'";
	$SQL->QUERY($Req);
}
function get_saison_info($IDSaison){
	$SQL = new sqlclass;
	$Req = "SELECT * FROM saison WHERE IDSaison = ".$IDSaison;
	$SQL->SELECT($Req);
	return $SQL->FetchArray();
}

function get_saison_list(){
	$SQL = new sqlclass;
	$Req = "SELECT IDSaison, Saison, Annee FROM saison WHERE Actif ORDER BY Annee ASC, Saison DESC";
	$SQL->SELECT($Req);
	$Ret = array();
	while($Rep = $SQL->FetchArray()){
		$Ret[$Rep[0]] = $Rep[1].$Rep[2];
	}
	return $Ret;
}