<?PHP

function get_client_info($IDClient){
	$SQL = new sqlclass();
	$Req = "SELECT * FROM client WHERE IDClient = '$IDClient'";
	$SQL->SELECT($Req);
	return $SQL->FetchArray();
}

function get_client_info_bycote($Cote){
	$SQL = new sqlclass();
	$Req = "SELECT IDClient FROM installation WHERE Cote='".$Cote."'";
	$SQL->Select($Req);
	$Rep = $SQL->FetchArray();
	$Req = "SELECT * FROM client WHERE IDClient = '".$Rep['IDClient']."'";
	$SQL->SELECT($Req);
	return $SQL->FetchArray();

}

function get_responsable_client($IDInstallation){
	$Ret = array();
	$SQL = new sqlclass();

	$Req = "SELECT IDResponsable FROM installation WHERE installation.IDInstallation=".$IDInstallation;
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	$RInfo = get_responsable_info($Rep['IDResponsable']);
	$Ret[$Rep['IDResponsable']] =  $RInfo['Prenom']." ".$RInfo['Nom'];

	
	$Req = "SELECT RespP, RespF FROM client JOIN installation on client.IDClient=installation.IDClient WHERE installation.IDInstallation=".$IDInstallation;

	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();

	if($Rep['RespP']<>0){
		$RInfo = get_responsable_info($Rep['RespP']);
		$Ret[$Rep['RespP']] =  $RInfo['Prenom']." ".$RInfo['Nom'];
	}		
	if($Rep['RespF']<>0 AND $Rep['RespF']<>$Rep['RespP']){
			$RInfo = get_responsable_info($Rep['RespF']);
		$Ret[$Rep['RespF']] = $RInfo['Prenom']." ".$RInfo['Nom'];
	}
	
	return $Ret;

}

function get_responsable_info($IDResponsable){
	$SQL = new sqlclass();
	$Req = "SELECT * FROM responsable WHERE IDResponsable = '$IDResponsable'";
	$SQL->SELECT($Req);
	return $SQL->FetchArray();
}

function get_last_id($table){
	$SQL = new sqlclass();
	$table = strtolower($table);
	$Req = "SELECT ID".ucfirst($table)." as a FROM ".$table." ORDER BY ID".ucfirst($table)." DESC LIMIT 0,1";
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	return $Rep['a'];
}

function get_installation_info($IDInstallation){
	$SQL = new sqlclass();
	$Req = "SELECT * FROM installation WHERE IDInstallation = '$IDInstallation'";
	$SQL->SELECT($Req);
	return $SQL->FetchAssoc();
}

function get_installations($IDClient){
	$SQL = new sqlclass();
	$Req = "SELECT IDInstallation FROM installation WHERE Actif AND IDClient = '$IDClient'";
	$SQL->SELECT($Req);
	$Ret = array();
	while ($Rep = $SQL->FetchAssoc()){
		$Ret[] = $Rep['IDInstallation'];
	}
	return $Ret;
}

function format_installation($IDInstallation, $is_super_admin){
	$Info = get_installation_info($IDInstallation);
	$SQL = new sqlclass();
	$Req = "SELECT IDRapport FROM clientrapport WHERE IDInstallation=".$IDInstallation;
	$SQL->SELECT($Req);
	$NumRapport = $SQL->NumRow();
	$Output = new HTML();
	$Output->opentable('500');
	$Output->openrow();
	$Output->opencol('100%',2);
		$Output->AddLink($Info['Lien'],$Info['Nom'],"_BLANK",'Titre');
		$Output->AddTexte("&nbsp; (".$Info['Cote'].")",'Titre');
		$Output->AddLink('index.php?Section=Installation_Form&IDInstallation='.$IDInstallation,'<img src=b_edit.png border=0>');
		$Output->AddLink('index.php?Section=Horshift&IDInstallation='.$IDInstallation,'<img src=b_save.png border=0>');
		if($is_super_admin){
		    $Output->AddLink('index.php?Cote='.$Info['Cote'],'<img src=b_fact.png border=0>');
        }

		$Output->AddLink('index.php?Section=ClientComment_Form&IDInstallation='.$IDInstallation,'<img src=b_conf.png border=0>');
		
	$Output->closecol();
	$Output->closerow();
	
	
	$Output->openrow();
	$Output->opencol();
		$Output->AddTexte("Type: ".get_installation_type($Info['IDType'])."
		Punch: ".get_flag($Info['Punch'])."
		Assistant: ".get_flag($Info['Assistant'])."
		Cadenas SdS: ".get_flag($Info['Cadenas']),'Texte');
	$Output->closecol();
	$Output->opencol();
		$Output->AddTexte("Dernière Inspection: � venir");
		$Output->br();
		if($NumRapport<>0)
			$Output->AddLink("index.php?Section=Rapport_ClientComment&IDInstallation=".$IDInstallation,"Rapport des commentaires des clients");
		
	$Output->closecol();
	$Output->closerow();
	
	
	
	$Output->Openrow();
	$Output->OpenCol('50%');
	$Output->addoutput(format_responsable($Info['IDResponsable'],'de la piscine',$Info['IDClient']),0,0);
	$Output->closecol();
	$Output->OpenCol('50%');
		$Output->AddTexte('Adresse de la piscine','Titre');
		$Output->br();
		$Output->AddTexte($Info['Adresse']);
		if(strlen($Info['Tel'])>4){
			$Output->br();
			$Output->AddTexte("Tel.: (".substr($Info['Tel'],0,3).") ".substr($Info['Tel'],3,3)."-".substr($Info['Tel'],6,4));
		if(strlen(substr($Info['Tel'],10,4))>1)
				$Output->AddTexte(" #".substr($Info['Tel'],10,4));
		}
	$Output->closecol();
	$Output->closerow();
if($Info['Notes']<>""){	
	$Output->openrow();
	$Output->opencol('100%',2);
		$Output->AddTexte("Notes: ".$Info['Notes'],'Texte');
	$Output->closecol();
	$Output->closerow();
	}
if($Info['Toilettes']<>""){	
	$Output->openrow();
	$Output->opencol('100%',2);
		$Output->AddTexte("Toilettes: ".$Info['Toilettes'],'Texte');
	$Output->closecol();
	$Output->closerow();
	}
	
	
	$Output->CloseTable();
	return $Output->send(1);
}
function format_responsable($IDResponsable,$What = "de la piscine",$IDClient=""){
		$Output = new HTML();
		$Repondant = get_responsable_info($IDResponsable);
		$Output->AddTexte('Responsable '.$What,'Titre');
		$Output->br();
		$Output->AddTexte($Repondant['Prenom']." ".$Repondant['Nom']);
		if(strlen($Repondant['Tel'])>4){
			$Output->br();
			$Output->AddTexte("Tel.: (".substr($Repondant['Tel'],0,3).") ".substr($Repondant['Tel'],3,3)."-".substr($Repondant['Tel'],6,4));
			if(strlen(substr($Repondant['Tel'],10,4))>1)
				$Output->AddTexte(" #".substr($Repondant['Tel'],10,4));
		}		
		if(strlen($Repondant['Cell'])>4){
			$Output->br();
			$Output->AddTexte("Cell.: (".substr($Repondant['Cell'],0,3).") ".substr($Repondant['Cell'],3,3)."-".substr($Repondant['Cell'],6,4));
		}
		
	return $Output->Send();
}
function format_client($IDClient){
	$Info = get_client_info($IDClient);
	$RespP = get_responsable_info($Info['RespP']);
	$RespF = get_responsable_info($Info['RespF']);
	$Output = new HTML();
	$Output->opentable(500);
	$Output->openrow();
	$Output->opencol('100%',2);
	$Output->addtexte("<div align=center>".$Info['Nom'],'Titre');
	$Output->AddLink('index.php?Section=Client_Form&IDClient='.$IDClient,'<img src=b_edit.png border=0>');
	$Output->AddLink('index.php?Section=Installation_Form&IDClient='.$IDClient,'<img src=b_ins.png border=0>');
	$Output->AddLink('index.php?Section=Responsable_Form&IDClient='.$IDClient,'<img src=b_conf.png border=0>');
		$Output->addtexte("</div>");
	$Output->closecol();
	$Output->closerow();
	$Output->Openrow();
	$Output->OpenCol('50%');
		$Output->addoutput(format_responsable($Info['RespP'],"piscine",$IDClient),0,0);
		$Output->br();
			$Output->addtexte('Facturation: ','Titre');
		IF($Info['Facturation']=='F'){
			$Facturation = "Fax";
		}else{
			$Facturation = "Email";
		}
		$Output->addtexte($Facturation);
		$Output->br();
		$Output->addoutput(format_responsable($Info['RespF'],"facturation",$IDClient),0,0);
		

	$Output->closecol();
	$Output->OpenCol('50%');
		$Output->AddTexte('Communication','Titre');
		$Output->br();
		if(strlen($Info['Tel'])>4){
			$Output->AddTexte("Tel.: (".substr($Info['Tel'],0,3).") ".substr($Info['Tel'],3,3)."-".substr($Info['Tel'],6,4));
			if(strlen(substr($Info['Tel'],10,4))>1)
				$Output->AddTexte("#".substr($Info['Tel'],10,4));
			$Output->br();
		}		
		if(strlen($Info['Fax'])>4){
			$Output->AddTexte("Fax.: (".substr($Info['Fax'],0,3).") ".substr($Info['Fax'],3,3)."-".substr($Info['Fax'],6,4));
		$Output->br();
		}		
		if($Info['Email']<>""){
		$Output->AddTexte("	Email.: ");
		$Output->AddLink("mailto:".$Info['Email'],$Info['Email'],'Titre');
		$Output->br();		
		}	
		$Output->AddTexte('Adresse','Titre');
		$Output->br();
		$Output->AddTexte($Info['Adresse']);
		$Output->br(2);
		$Output->AddTexte('<b>Mot de passe:</b> '.$Info['Password']);
			
	$Output->CloseCol();
	$Output->CloseRow();
	$Output->CloseTable();
	return $Output->send(1);
}
function get_installation_type($str){
	SWITCH ($str){
		CASE "E":{
			Return "Ext�rieure";
		}
		CASE "ES":{
			Return "Ext�rieure + Spa";
		}
		CASE "I":{
			Return "Int�rieure";
		}
		CASE "IS":{
			Return "Int�rieure + Spa";
		}
		CASE "EP":{
			Return "Ext�rieure + Patogeoire";
		}	
	}
}
function get_flag($flag){
	if($flag==1)
		Return "Oui";
	Return "Non";
}

function get_installation_by_cote_in_string($Cote, $Actif=1, $Saison=1){
	$SQL = new sqlclass;
	$Req = "SELECT Nom FROM installation WHERE `Cote` = '".$Cote."' AND Actif=".$Actif." ORDER BY Nom ASC";
	$SQL->SELECT($Req);
	$ret = "";
	while($Rep = $SQL->FetchArray())
		$ret = $ret.", ".stripslashes($Rep[0]);

	return substr($ret,2);
}

function get_installation_bycote($Cote){

    $SQL = new SqlClass();
    $Req = "SELECT IDInstallation, Nom FROM installation WHERE `Cote` = '".$Cote."' AND Actif ORDER BY Nom ASC";
    $SQL->SELECT($Req);
    $ret=array();
	while($Rep = $SQL->FetchArray())
	$ret[$Rep['IDInstallation']] = $Rep['Nom'];

        return $ret;

}

?>