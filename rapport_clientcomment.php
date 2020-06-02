<?PHP
$SQL = new sqlclass();

if(!isset($_GET['IDInstallation'])){
	$Req = "SELECT FROM_UNIXTIME(`Date`,'%Y') as A, clientrapport.IDInstallation, client.IDClient, clientrapport.IDInstallation, installation.Nom, client.Nom FROM clientrapport JOIN installation JOIN client on clientrapport.IDInstallation=installation.IDInstallation AND installation.IDClient = client.IDClient ORDER BY FROM_UNIXTIME(`Date`,'%Y')  DESC, client.Nom ASC"; 
	$SQL->Select($Req);
	$OldYear=Null;
	$OldClientID=Null;
	$MainOutput->OpenTable(500);
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',2);
		$MainOutput->AddLink('index.php?Section=ClientComment_Form','Ajouter un rapport de commentaire');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	while($Rep = $SQL->FetchArray()){
		if($OldYear<>$Rep[0]){
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',2);
			$MainOutput->AddTexte("<div align=center>".$Rep[0]."</div>",'Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$OldYear=$Rep[0];
		}
		
		$MainOutput->OpenRow();

		if($OldClientID<>$Rep[2]){
			$MainOutput->OpenCol();
				$MainOutput->AddTexte($Rep[5],'Titre');
			$MainOutput->CloseCol();
			$OldClientID = $Rep[2];
		}else{
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('&nbsp;');
			$MainOutput->CloseCol();
		}
		
		$MainOutput->OpenCol();
			$MainOutput->AddLink('index.php?Section=Rapport_ClientComment&IDInstallation='.$Rep[3],$Rep[4]);
		$MainOutput->CloseCol();
		
		$MainOutput->CloseRow();
	}
	
	$MainOutput->CloseTable();
}else{

	$MainOutput->OpenTable(700);
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',3);
		$MainOutput->AddTexte('&nbsp;');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	$Req = "SELECT responsable.Nom, responsable.Prenom, installation.Nom, Comment, ToImprove, BeenImproved, Date FROM clientrapport JOIN responsable JOIN installation ON clientrapport.IDInstallation = installation.IDInstallation AND clientrapport.IDResponsable = responsable.IDResponsable ORDER BY Date DESC";
	$SQL->Select($Req);
	$Month = get_month_list("long");
	while($Rep = $SQL->FetchArray()){
		$MainOutput->OpenRow();
		$MainOutput->Opencol(200);
			$MainOutput->AddTexte($Rep[2],'Titre');
		$MainOutput->Closecol();
		$MainOutput->OpenCol(350);
			$MainOutput->AddTexte($Rep[1]." ".$Rep[0]);
		$MainOutput->CloseCol();
		$MainOutput->OpenCol(150);
		$Date = get_date($Rep[6]);
		$MainOutput->AddTexte($Date['d']." ".$Month[intval($Date['m'])]." ".$Date['Y']);
	 	$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',3);
			$MainOutput->AddTexte('--------------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
		$MainOutput->OpenRow();
		$MainOutput->OpenCol(200);
			$MainOutput->AddTexte('Commentaire','Titre');
		$MainOutput->CloseCol();
		$MainOutput->Opencol('',2);
			$MainOutput->AddTexte($Rep[3]);
		$MainOutput->CloseCol();
		
		$MainOutput->OpenRow();
		$MainOutput->OpenCol(200);
			$MainOutput->AddTexte('À améliorer','Titre');
		$MainOutput->CloseCol();
		$MainOutput->Opencol('',2);
			$MainOutput->AddTexte($Rep[4]);
		$MainOutput->CloseCol();
		
		
		$MainOutput->OpenRow();
		$MainOutput->OpenCol(200);
			$MainOutput->AddTexte('à été amélioré','Titre');
		$MainOutput->CloseCol();
		$MainOutput->Opencol('',2);
			$MainOutput->AddTexte($Rep[5]);
		$MainOutput->CloseCol();
		
			$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',3);
			$MainOutput->AddTexte('&nbsp;');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
	}
}

echo $MainOutput->Send(1);
?>