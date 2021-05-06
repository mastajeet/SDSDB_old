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

function format_responsable($IDResponsable,$What = "de la piscine",$IDClient=""){
    $MainOutput = new HTMLContainer();
    $Repondant = get_responsable_info($IDResponsable);
    $MainOutput->AddTexte('Responsable '.$What,'Titre');
    $MainOutput->br();
    $MainOutput->AddTexte($Repondant['Prenom']." ".$Repondant['Nom']);
    if(strlen($Repondant['Tel'])>4){
        $MainOutput->br();
        $MainOutput->AddTexte("Tel.: (".substr($Repondant['Tel'],0,3).") ".substr($Repondant['Tel'],3,3)."-".substr($Repondant['Tel'],6,4));
        if(strlen(substr($Repondant['Tel'],10,4))>1)
            $MainOutput->AddTexte(" #".substr($Repondant['Tel'],10,4));
    }
    if(strlen($Repondant['Cell'])>4){
        $MainOutput->br();
        $MainOutput->AddTexte("Cell.: (".substr($Repondant['Cell'],0,3).") ".substr($Repondant['Cell'],3,3)."-".substr($Repondant['Cell'],6,4));
    }
    return $MainOutput->send(1);
}


function format_client($IDClient){
	$Info = get_client_info($IDClient);
	$RespP = get_responsable_info($Info['RespP']);
	$RespF = get_responsable_info($Info['RespF']);
	$Output = new HTMLContainer();
	$Output->opentable(500);
	$Output->openrow();
	$Output->opencol('100%',2);
	$Output->addtexte("<div align=center>".$Info['Nom'],'Titre');
	$Output->AddLink('index.php?Section=Client_Form&IDClient='.$IDClient, '<img src=assets/buttons/b_edit.png border=0>');
	$Output->AddLink('index.php?Section=Installation_Form&IDClient='.$IDClient, '<img src=assets/buttons/b_ins.png border=0>');
	$Output->AddLink('index.php?Section=Responsable_Form&IDClient='.$IDClient, '<img src=assets/buttons/b_conf.png border=0>');
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
			Return "Extérieure";
		}
		CASE "ES":{
			Return "Extérieure + Spa";
		}
		CASE "I":{
			Return "Intérieure";
		}
		CASE "IS":{
			Return "Intérieure + Spa";
		}
		CASE "EP":{
			Return "Extérieure + Patogeoire";
		}	
	}
}

function get_flag($flag){
	if($flag==1)
		Return "Oui";
	Return "Non";
}



?>