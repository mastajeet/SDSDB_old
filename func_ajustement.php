<?PHP

function create_banque($IDEmploye,$Salaire){
	$SQL = new sqlclass;
	$Req = "INSERT INTO banque(`IDEmploye`,`Salaire`) VALUES('".$IDEmploye."','".$Salaire."')";
	$SQL->INSERT($Req);
	return get_last_id('banque');
}

function get_IDBanque($IDEmploye,$Salaire){
	$SQL = new sqlclass;
	$Req = "SELECT IDBanque FROM banque WHERE `IDEmploye` = '".$IDEmploye."' && `Salaire` = '".$Salaire."'";
	$SQL->SELECT($Req);
	if($SQL->NumRow()==0){
		$Rep['IDBanque'] = create_banque($IDEmploye,$Salaire);
	}else{
		$Rep = $SQL->FetchArray();
	}
	return $Rep['IDBanque'];
}

function add_ajustement($IDEmploye,$Salaire,$NBH,$IDPaye,$Raison){
	$SQL = new sqlclass;
	$IDBanque = get_IDBanque($IDEmploye,$Salaire);
	$Req = "INSERT INTO ajustement(`IDBanque`,`NBH`,`IDPaye`,`Raison`) VALUES('".$IDBanque."','".$NBH."','".$IDPaye."','".addslashes($Raison)."')";
	$SQL->INSERT($Req);
	$Req = "SELECT NBH FROM banque WHERE `IDBanque` = '".$IDBanque."'";
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	$NBH = $Rep['NBH'] - $NBH;
	$Req = "UPDATE banque SET `NBH`='".$NBH."' WHERE `IDBanque` = '".$IDBanque."'";
	$SQL->QUERY($Req);
}

function get_employe_totalh_sa($IDPaye){
	$SQL = new sqlclass;
	$Req = "SELECT IDEmploye, sum(S10+S11+S12+S13+S14+S15+S16+S20+S21+S22+S23+S24+S25+S26) FROM timesheet WHERE `IDPaye`='".$IDPaye."' GROUP BY IDEmploye ORDER BY IDEmploye ASC";
	$SQL->SELECT($Req);
	$Ret = array();
	while($Rep = $SQL->FetchArray()){
		$Ret[$Rep[0]] = $Rep[1];
	}
	return $Ret;
}

function get_employe_totalh_aa($IDPaye){
	$SQL = new sqlclass;
	$Req = "SELECT IDEmploye, sum(S10+S11+S12+S13+S14+S15+S16+S20+S21+S22+S23+S24+S25+S26+Ajustement) FROM timesheet WHERE `IDPaye`='".$IDPaye."' GROUP BY IDEmploye ORDER BY IDEmploye ASC";
	$SQL->SELECT($Req);
	$Ret = array();
	while($Rep = $SQL->FetchArray()){
		$Ret[$Rep[0]] = $Rep[1];
	}
	return $Ret;
}

function get_overtime($IDPaye){
	$TotalH = get_employe_totalh_sa($IDPaye);
	$OverTime = array();
	foreach($TotalH as $k=>$v){
		if($v>80){
			$OverTime[$k] = $v-80;
		}
	}
	return $OverTime;
}

function get_ajustabletime($IDPaye){
	$TotalH = get_employe_totalh_aa($IDPaye);
	$Ajustable = array();
	foreach($TotalH as $k=>$v){
		if($v<=80){
			$Ajustable[$k] = 80-$v;
		}
	}
	return $Ajustable;
}

function ajust_overtime($IDPaye){
	$SQL = new sqlclass;
	foreach(get_overtime($IDPaye) as $k=>$v){
		$Req = "SELECT Salaire, sum(S10+S11+S12+S13+S14+S15+S16+S20+S21+S22+S23+S24+S25+S26) as a FROM timesheet WHERE `IDEmploye`='".$k."' && `IDPaye` = '".$IDPaye."' GROUP BY Salaire ORDER BY a DESC LIMIT 0,1";
		$SQL->SELECT($Req);
		$Rep = $SQL->FetchArray();
		add_ajustement($k,$Rep[0],-$v,$IDPaye,"À dépassé 80h");
	}
}

function get_employe_banque($IDEmploye){
	$SQL = new sqlclass;
	$Req = "SELECT IDBanque, Salaire, NBH, IDPaye FROM banque WHERE `IDEmploye`='".$IDEmploye."'";
	$SQL->SELECT($Req);
	$Ret = array();
	while($Rep = $SQL->FetchArray()){
		$Ret[$Rep[0]] = array('Salaire'=>$Rep[1],'NBH'=>$Rep[2]);
	}
	return $Ret;
}

function ajust_negative_banque($IDPaye){
	$SQL= new sqlclass;
	$SQL2 = new sqlclass;
	$Req = "SELECT banque.IDEmploye, IDBanque, banque.Salaire, NBH FROM banque JOIN timesheet ON banque.IDEmploye = timesheet.IDEmploye WHERE IDPaye = '".$IDPaye."' && NBH<'0'";
	//AINSI JE RAMASSE TOUT CEUX QUI TRAVAILLENT SUR LA PAYE ET QUI ONT UN AJUSTEMENT NÉGATIF À FAIRE
	$SQL->SELECT($Req);
	while($Rep = $SQL->FetchArray()){
		$NBH = -$Rep[3];
		$Up = 0;
		$Req2 = "SELECT sum(S10+S11+S12+S13+S14+S15+S16+S20+S21+S22+S23+S24+S25+S26) as a FROM timesheet WHERE IDEmploye='".$Rep[0]."' AND Salaire='".$Rep[2]."' AND Paye='".$IDPaye."' ";
		$SQL2->SELECT($Req2);
		$Rep2 = $SQL->FetchArray();
		if($Rep2[0]<>0){
			$Up = min($NBH,$Rep2[0]);
			add_ajustement($Rep[0],$Rep[2],-$Up,$IDPaye,"Voir Modifications manuelles à la banque d\'heure");
		}
		if($Up<>$NBH){
			$TotalPayable=0;
			//Banque
			$Req2 = "SELECT sum(NBH*Salaire) FROM banque WHERE Salaire <> '".$Rep[2]."' && IDEmploye='".$Rep[0]."'";
			$SQL2->SELECT($Req2);
			$Rep2 = $SQL2->FetchArray();
			$TotalPayable = $Rep2[0];
			echo $TotalPayable;
			$Req2 = "SELECT sum((S10+S11+S12+S13+S14+S15+S16+S20+S21+S22+S23+S24+S25+S26+Ajustement)*Salaire) as a FROM timesheet WHERE IDEmploye='".$Rep[0]."' AND Salaire<>'".$Rep[2]."' AND IDPaye='".$IDPaye."' ";
			$Rep2 = $SQL2->FetchArray();
						$TotalPayable = $TotalPayable+$Rep2[0];
			echo $TotalPayable;
			$NBPossible = floor($TotalPayable/$Rep[2]);
			$Left = $NBH-$Up;
			add_ajustement($Rep[0],$Rep[2],-min($Left,$NBPossible),$IDPaye,"Voir Modifications manuelles à la banque d\'heure");
		}
	}
}


function ajust_ajustable($IDPaye){
	
}


function get_IDPaye($Semaine){
	$SQL = new sqlclass;
	$Req = "SELECT IDPaye FROM paye WHERE Semaine1='".$Semaine."' OR Semaine2='".$Semaine."'";
	$SQL->SELECT($Req);
	if($SQL->NumRow()==0){
		return FALSE;
	}else{
		$Rep = $SQL->FetchArray();
		return $Rep[0];
	}
}

function ajust_cash($IDPaye){
	$SQL = new sqlclass;
	$SQL2 = new sqlclass;
	$Req = "SELECT IDEmploye, Ajustement FROM employe WHERE Ajustement <> '0' ORDER BY IDEmploye ASC";
	$SQL->SELECT($Req);
	while($Rep = $SQL->FetchArray()){
		$Req2 = "INSERT INTO timesheet(`IDEmploye`,`Salaire`,`Ajustement`,`IDPaye`) VALUES('".$Rep[0]."','".$Rep[1]."','1','".$IDPaye."')";
		$SQL2->INSERT($Req2);
	}
	$Req = "UPDATE employe SET Ajustement='0'";
	$SQL->Query($Req);
}

?>