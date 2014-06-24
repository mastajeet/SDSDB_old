<?PHP
function get_horshift_info($IDShift){
	$SQL = new sqlclass();
	$Req = "SELECT * FROM horshift WHERE IDHorshift = '$IDShift'";
	$SQL->SELECT($Req);
	return $SQL->FetchArray();
}
function get_shift_info($IDShift){
	$SQL = new sqlclass();
	$Req = "SELECT * FROM shift WHERE IDShift = '$IDShift'";
	$SQL->SELECT($Req);
	return $SQL->FetchArray();
}

function get_non_working($Time){
	$SQL = new sqlclass();
	$Semaine = get_last_sunday(0,$Time);
	$Jour = date('w',$Time);
	$Req = "SELECT DISTINCT IDEmploye FROM shift WHERE Semaine=".$Semaine." AND Jour=".$Jour;
	$SQL->SELECT($Req);
	$Working = "";
	while($Rep = $SQL->FetchArray()){
		$Working .= $Rep[0].",";
	}
	$Working = substr($Working,0,-1);
	$Session = get_vars("Saison");
	$Req2 = "SELECT IDEmploye, Nom, Prenom, TelP,Cell FROM employe WHERE Session='".$Session."' AND !Cessation AND IDEmploye not in(".$Working.") ORDER BY Nom ASC,Prenom ASC";
	$SQL->SELECT($Req2);
	$ret = array();
	while($Rep = $SQL->FetchArraY()){
		$ret[$Rep[0]] = array('Nom'=>$Rep[1],'Prenom'=>$Rep[2],'Telp'=>$Rep[3],'Cell'=>$Rep[4]);
	}
	return $ret;
 }


function get_askedRemplacements($IDEmploye){
	$SQL = new sqlclass();
	$Req = "SELECT DISTINCT remplacement.Asked, shift.IDInstallation, shift.Semaine, shift.Jour, installation.Nom, remplacement.Raison FROM remplacement JOIN shift JOIN installation on remplacement.IDShift = shift.IDShift And shift.IDInstallation = installation.IDInstallation WHERE IDEmployeS = ".$IDEmploye." ORDER BY shift.Semaine DESC, shift.Jour DESC";
		$SQL->SELECT($Req);
	$Ret = array();
	while($Rep = $SQL->FetchArray()){
			$Stamp = whatdate($Rep[2],$Rep[3]);
				$Ret[] = array('DateDemande'=>datetostr($Rep[0]),'Installation'=>$Rep[4],'Raison'=>$Rep[5], 'Date'=>datetostr($Stamp));
	}
	return $Ret; 
}

function get_horaire_info($IDInstallation){
	$SQL = new sqlclass();
	$SQL2 = new sqlclass();
	$Req = "SELECT IDHoraire FROM installation WHERE IDInstallation=".$IDInstallation;
	$SQL->SELECT($Req);
	$Info = $SQL->FetchArray();
	if($Info['IDHoraire']==0){
		$Info = get_installation_info($IDInstallation);
		$Req2 = "INSERT INTO horaire(`Nom`) VALUES ('".$Info['Nom']."')";
		$SQL2->INSERT($Req2);
		$Info['IDHoraire'] = get_last_id('horaire');
		$Req3 = "UPDATE installation set IDHoraire = ".$Info['IDHoraire']." WHERE IDInstallation=".$IDInstallation;
		$SQL2->INSERT($Req3);
	}
	$Req = "SELECT * FROM horaire WHERE IDHoraire = ".$Info['IDHoraire'];
	$SQL->SELECT($Req);
	
	return $SQL->FetchArray();
}

function get_day_shift($ID,$d,$Type="OFFICIAL"){
	//Si IDInstallation est sett�, c'est qu'on veut l'horaire R�EL
	//SI IDHoraire est sett� c'est qu'on veut l'horaire officiel
	$Output = array();
	if($Type=="OFFICIAL"){
		$SQL = new sqlclass();
		$Req = "SELECT * FROM horshift WHERE IDHoraire='$ID' && Jour='$d' ORDER BY Assistant ASC, Start ASC";
		$SQL->SELECT($Req);
		while($Rep = $SQL->FetchArray()){
			if(!isset($Rep['IDEmploye']))
				$Rep['IDEmploye']==0;
			$Output[] = array('IDEmploye'=>$Rep['IDEmploye'],'IDHorshift'=>$Rep['IDHorshift'],'Start'=>$Rep['Start'],'End'=>$Rep['End'],'Commentaire'=>$Rep['Commentaire'],'TXH'=>$Rep['TXH'],'Salaire'=>$Rep['Salaire'],'Assistant'=>$Rep['Assistant'],'Confirm'=>$Rep['Confirm']);
		}
	}else{
		$SQL = new sqlclass();
		$Req = "SELECT * FROM shift WHERE IDInstallation='$ID' && Jour='".$d['d']."' && Semaine='".$d['semaine']."' ORDER BY Assistant ASC, Start ASC";		$SQL->SELECT($Req);
		$SQL->SELECT($Req);
		while($Rep = $SQL->FetchArray()){
			if(!isset($Rep['IDEmploye']))
				$Rep['IDEmploye']==0;
			$Output[] = array('Semaine'=>$Rep['Semaine'],'IDShift'=>$Rep['IDShift'],'Start'=>$Rep['Start'],'End'=>$Rep['End'],'Warn'=>$Rep['Warn'],'IDEmploye'=>$Rep['IDEmploye'],'Commentaire'=>$Rep['Commentaire'],'TXH'=>$Rep['TXH'],'Salaire'=>$Rep['Salaire'],'Assistant'=>$Rep['Assistant'],'Confirme'=>$Rep['Confirme'],'Paye'=>$Rep['Paye'],'Facture'=>$Rep['Facture']);
		}
	}
	return $Output;	
}

function copy_horshift($IDInstallation,$Date){
	$SQL = new sqlclass;
	$Req = "SELECT IDHoraire FROM installation WHERE IDInstallation='".$IDInstallation."'";
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	$IDHoraire = $Rep[0];
	$Week = get_last_sunday(0,$Date);
	//echo $Week."CHECK"."<br>";
	$Target = $Date - $Week;
	$DayTime = bcmod($Target,86400);
	//$Day = ($Target-$DayTime)/86400;
	$Day = intval(date("w",$Date));
	$Shift = get_day_shift($IDHoraire,$Day);
	$Req = "DELETE FROM shift WHERE IDInstallation='".$IDInstallation."' && Semaine='".$Week."' && Jour='".$Day."'";
	$SQL->Query($Req);
		foreach($Shift as $v){
		
		if($v['TXH']==0){
			$Req = "
			SELECT client.TXH 
			FROM client JOIN installation on 
			installation.IDClient = client.IDClient WHERE installation.IDInstallation = '".$IDInstallation."'";
			$SQL->SELECT($Req);
			$Rep = $SQL->FetchArray();
			$v['TXH'] = $Rep['TXH'];
		}
		
		if(!isset($v['Assistant'])){
			$v['Assistant']="";
		}

		$Req = "INSERT INTO shift(`IDInstallation`, `Semaine`, `Jour`, `Start`,`End`,`Assistant`,`Commentaire`,`Salaire`,`TXH`,`IDEmploye`) 
		VALUES('".$IDInstallation."','".$Week."','".$Day."','".$v['Start']."','".$v['End']."','".$v['Assistant']."','".addslashes($v['Commentaire'])."','".$v['Salaire']."','".$v['TXH']."','".$v['IDEmploye']."')";
				$SQL->INSERT($Req);
	}
}

function get_paye_info($IDPaye){
	$SQL = new sqlclass;
	$Req = "SELECT * FROM paye WHERE IDPaye ='".$IDPaye."'";
	$SQL->SELECT($Req);
	return $SQL->FetchArray();
}


function generate_shift($IDInstallation,$Start,$End){
	$Start = intval($Start);
	$End = intval($End);
        
        
        $Offset =0;
        $DayLength=0;        
        for($Time=$Start;$Time<=$End;$Time += get_day_length($Time)){
		copy_horshift($IDInstallation,$Time);
                    
                    
                
	}
}

?>