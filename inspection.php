<?PHP
if(isset($_GET['TODO'])){
$NMois = get_month_list();
$NDay= get_day_list();
	//On enleve ceux qui ont d�j� �t� inspect�es ou planifi�es
	$Req = "SELECT IDInstallation FROM inspection WHERE (!isnull(DateI) OR !isnull(DateP)) AND Annee=".get_vars("Boniyear");
	$SQL->Select($Req);
	
	$NOTIN = "0";
	while($Rep = $SQL->FetchArray()){
		$NOTIN .= ",".$Rep['IDInstallation'];
	}

$MainOutput->OpenTable(600);
$MainOutput->OpenRow();
$MainOutput->OpenCol(300);
	$MainOutput->OpenTable(300);
	
	$Req = "SELECT IDInspection,  installation.IDInstallation,installation.Nom,client.IDClient, DateR FROM installation JOIN client JOIN inspection on client.IDClient= installation.IDClient AND installation.IDInstallation = inspection.IDInstallation WHERE !isnull(inspection.DateR) AND installation.IDInstallation NOT IN (".$NOTIN.") and Annee=".get_vars("Boniyear")." ORDER BY DateR ASC, installation.Nom ASC";
	
	$SQL->Select($Req);
	if($SQL->NumRow()>0){
		
	$MainOutput->OpenRow();
	$MainOutput->OpenCol(300,3);
			$MainOutput->AddTexte('Client � rappeller','Titre');
	$MainOutput->Closecol();
	$MainOutput->CloseRow();
	$OLDJour = 0;
	$OLDMois = 0;
	
		while($Rep=$SQL->FetchArray()){
		
	
		$Date = getdate($Rep['DateR']);
		
		if($OLDJour<>$Date['mday'] OR $OLDMois<>$Date['mon']){
		$MainOutput->OpenRow();
		$MainOutput->OpenCol(300,3);
			$MainOutput->AddTexte("- ".$NDay[$Date['wday']]." ".$Date['mday']." ".$NMois[$Date['mon']],'Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$OLDJour=$Date['mday'] ;
		$OLDMois=$Date['mon'];
		}
		
		$MainOutput->OpenRow();
	
		$MainOutput->Opencol('16');
			$MainOutput->Addpic('b_help.png','border=0',"index.php?MenuClient=".$Rep['IDClient'],'_BLANK');
		$MainOutput->CloseCol();

		$MainOutput->Opencol('16');
			$MainOutput->Addpic('b_conf.png','border=0','index.php?Section=PlanifieInspection&IDInspection='.$Rep['IDInspection']);
		$MainOutput->CloseCol();
		
		
	
		$MainOutput->OpenCol(268);
			$MainOutput->AddLink('index.php?Section=AddInspection&IDInspection='.$Rep['IDInspection'],$Rep['Nom']);
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$NOTIN .= ",".$Rep['IDInstallation'];
	}
	}
	

	$Req = "SELECT IDInstallation, installation.Nom,client.IDClient FROM installation JOIN client on client.IDClient= installation.IDClient WHERE installation.Actif AND !client.Piece AND IDInstallation NOT IN (".$NOTIN.") ORDER BY installation.Nom ASC";
	$SQL->Select($Req);

	$MainOutput->OpenRow();
	$MainOutput->OpenCol(300,3);
			$MainOutput->AddTexte('Inspections � planifier','Titre');
	$MainOutput->Closecol();
	$MainOutput->CloseRow();
	$ARappeller = FALSE;
	while($Rep = $SQL->FetchArray()){
		$MainOutput->OpenRow();
	
		$MainOutput->Opencol('16');
			$MainOutput->Addpic('b_help.png','border=0',"index.php?MenuClient=".$Rep['IDClient'],"_BLANK");
		$MainOutput->CloseCol();
		
		$MainOutput->Opencol('16');
			$MainOutput->Addpic('b_conf.png','border=0','index.php?Section=PlanifieInspection&IDInstallation='.$Rep['IDInstallation']);
		$MainOutput->CloseCol();
		
	
		$MainOutput->OpenCol(268);
			$MainOutput->AddLink('index.php?Section=AddInspection&IDInstallation='.$Rep['IDInstallation'],$Rep['Nom']);
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
	}
	$MainOutput->CloseTable();
$MainOutput->CloseCol();

$MainOutput->OpenCol(300);
	
	$Req = "SELECT installation.IDInstallation, installation.Nom as nomIns, client.IDClient, IDInspection, DateP, employe.Nom, employe.Prenom FROM installation JOIN client JOIN inspection JOIN employe on client.IDClient= installation.IDClient AND inspection.IDInstallation = installation.IDInstallation AND employe.IDEmploye = inspection.IDEmploye WHERE isnull(inspection.DateI) AND !isnull(inspection.DateP) AND Annee= ".get_vars('Boniyear')." ORDER BY DateP ASC";
	$SQL->Select($Req);
	$MainOutput->OpenTable(300);
	$MainOutput->OpenRow();
	$MainOutput->OpenCol(300,3);
			$MainOutput->AddTexte('Inspections planifi�es','Titre');
	$MainOutput->Closecol();
	$MainOutput->CloseRow();
	
	$OLDJour = 0;
	$OLDMois = 0;
	while($Rep = $SQL->FetchArray()){
		$Date = getdate($Rep['DateP']);
		
		if($OLDJour<>$Date['mday'] OR $OLDMois<>$Date['mon']){
		$MainOutput->OpenRow();
		$MainOutput->OpenCol(300,3);
			$MainOutput->AddTexte($NDay[$Date['wday']]." ".$Date['mday']." ".$NMois[$Date['mon']],'Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$OLDJour=$Date['mday'] ;
		$OLDMois=$Date['mon'];
		}
		
		$MainOutput->OpenRow();
		$MainOutput->Opencol('16');
			$MainOutput->Addpic('b_help.png','border=0',"index.php?MenuClient=".$Rep['IDClient'],'_BLANK');
		$MainOutput->CloseCol();

		$MainOutput->Opencol('16');
			$MainOutput->Addpic('b_conf.png','border=0','index.php?Section=PlanifieInspection&IDInspection='.$Rep['IDInspection']);
		$MainOutput->CloseCol();
		

		$MainOutput->OpenCol(268);
		if($Date['minutes']==0)
			$Date['minutes']="00";
			$MainOutput->AddTexte($Date['hours']."h".$Date['minutes']." :",'Titre');
			$MainOutput->AddLink('index.php?Section=AddInspection&IDInspection='.$Rep['IDInspection'],$Rep['nomIns']);
		if($Rep['Nom']<>""){
			$MainOutput->AddTexte("par ",'Titre');
			$MainOutput->AddTexte($Rep['Prenom']." ".$Rep['Nom']);
		}
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
	}
	$MainOutput->CloseTable();
$MainOutput->CloseCol();
	
	
}else{


$Req = "SELECT installation.IDInstallation, installation.Nom as nomIns,client.IDClient, IDInspection, DateI, employe.Nom, employe.Prenom, Envoye, Confirme, Materiel, MaterielPret, MaterielLivre FROM installation JOIN client JOIN inspection JOIN employe on client.IDClient= installation.IDClient AND inspection.IDInstallation = installation.IDInstallation AND employe.IDEmploye = inspection.IDEmploye WHERE !isnull(inspection.DateI) AND Annee= ".get_vars('Boniyear')." ORDER BY nomIns ASC";
	$SQL->Select($Req);
	$MainOutput->OpenTable(452);
	$MainOutput->OpenRow();
	$MainOutput->OpenCol(452,10);
			$MainOutput->AddTexte('Inspections effectu�es','Titre');
	$MainOutput->Closecol();
	$MainOutput->CloseRow();
	$NMois = get_month_list();
	$NDay= get_day_list();
	$OLDJour = 0;
	$OLDMois = 0;
	while($Rep = $SQL->FetchArray()){
		
		$MainOutput->OpenRow();
	
	
		$MainOutput->Opencol('16');
			$MainOutput->Addlink("index.php?MenuClient=".$Rep['IDClient'], '<img src=assets/buttons/b_help.png border=0>','_BLANK');
		$MainOutput->CloseCol();
	
		$MainOutput->Opencol('16');
			$MainOutput->Addlink('index.php?Section=AddInspection&IDInspection='.$Rep['IDInspection'], '<img src=assets/buttons/b_edit.png border=0>');
		$MainOutput->CloseCol();
		
		$MainOutput->Opencol('16');
			$MainOutput->Addlink('index.php?Section=Generate_InspectionReport&ToPrint=TRUE&IDInspection='.$Rep['IDInspection'], '<img src=assets/buttons/b_print.png border=0>','_BLANK');
		$MainOutput->CloseCol();
		
		$MainOutput->Opencol('16');
			$MainOutput->Addlink('index.php?Action=Generate_FactureInspectiont&ToPrint=TRUE&IDInspection='.$Rep['IDInspection'], '<img src=assets/buttons/b_fact.png border=0>','_BLANK');
		$MainOutput->CloseCol();
		
			$MainOutput->OpenCol(308);	
			$MainOutput->AddLink('index.php?Section=SuiviInspection&IDInspection='.$Rep['IDInspection'],$Rep['nomIns']);
		if($Rep['Nom']<>""){
			$MainOutput->AddTexte("par ",'Titre');
			$MainOutput->AddTexte($Rep['Prenom']." ".$Rep['Nom']);
		}
		$MainOutput->CloseCol();
		

		$IMGEnvoye = "b_linkBW.png";
		$IMGConfirme = "b_confBW.png";
		$IMGMateriel = "b_matBW.png";
		$IMGMaterielPret = "b_monteBW.png";
		$IMGMaterielLivre = "b_okBW.png";
		
		if($Rep['Envoye'])
			$IMGEnvoye = "b_link.png";
		if($Rep['Confirme'])
			$IMGConfirme = "b_conf.png";
		if($Rep['Materiel'])
			$IMGMateriel = "b_mat.png";
		if($Rep['MaterielPret'])
			$IMGMaterielPret = "b_monte.png";
		if($Rep['MaterielLivre'])
			$IMGMaterielLivre = "b_ok.png";
		if($Rep['Materiel']==-1){
			$IMGMateriel = "carlos.gif";
			$IMGMaterielPret = "carlos.gif";
			$IMGMaterielLivre = "b_ok.png";
		}
		
		
		
		
		
		
		$MainOutput->Opencol('16');
			$MainOutput->Addpic($IMGEnvoye,'border=0, width=16');
		$MainOutput->CloseCol();
		
		
		$MainOutput->Opencol('16');
			$MainOutput->Addpic($IMGConfirme,'border=0, width=16');
		$MainOutput->CloseCol();
		
		$MainOutput->Opencol('16');
			$MainOutput->Addpic($IMGMateriel,'border=0, width=16');
		$MainOutput->CloseCol();
		
		
		$MainOutput->Opencol('16');
			$MainOutput->Addpic($IMGMaterielPret,'border=0, width=16');
		$MainOutput->CloseCol();
		
		$MainOutput->Opencol('16');
			$MainOutput->Addpic($IMGMaterielLivre,'border=0, width=16');
		$MainOutput->CloseCol();
		
		
		
		
		
		$MainOutput->CloseRow();
		
	}
	
	
	
	
	
	
	$MainOutput->CloseTable();


}
echo $MainOutput->Send(1);
?>