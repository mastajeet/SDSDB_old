<?PHP
	function get_materiel_info($IDItem){
		$SQL = new sqlclass();
		$Req = "SELECT * FROM item WHERE IDItem = ".$IDItem;
		$SQL->SELECT($Req);
		return $SQL->FetchArray();	
	}
?>