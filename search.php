<?PHP
	
		
	function generateSearchResult($Titre,$Req,$ModelLink){
		$HTML = new HTML();
		$SQL = new SQLclass();
		
		$SQL->Select($Req);
		
		$HTML->OpenTable(400);
		$HTML->OpenRow();
			$HTML->OpenCol('100%',2);	
				$HTML->AddTexte($Titre,'Titre');
			$HTML->CloseCol();
		$HTML->CloseRow();
		
		$HTML->OpenCol(10);
		$HTML->AddTexte("&nbsp;");
		$HTML->CloseCol();
		
		$HTML->OpenCol(390);
		
		if($SQL->NumRow()==0){
			$HTML->AddTexte('Aucun résultat dans cette catégorie');	
		}else{
			while($Rep = $SQL->FetchArray()){
				
				$HTML->AddLink($ModelLink.$Rep[0],$Rep[1]);
				$HTML->br();
			}
			

		}
		$HTML->CloseCol();
		$HTML->CloseTable();
		return $HTML->send(); 
	
	}
	
	if(!isset($_POST['FORMSearch'])){
		$MainOutput->addForm('Recherche');
		$MainOutput->InputHidden_Env('Section','Search');
		$MainOutput->InputText('Search','À Trouver');
		$MainOutput->FormSubmit('Rechercher');
	}else{
	
	//Client

	
	
	
	$MainOutput->OpenTable();
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('<b>Recherche:</b> '.$_POST['FORMSearch']);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	$Rep = "SELECT IDClient, Nom FROM client WHERE Nom LIKE  '%".$_POST['FORMSearch']."%' ORDER BY Nom ASC";
	$Model = "index.php?MenuClient=";
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->Addoutput(generateSearchResult('Clients',$Rep,$Model),0,0);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	
	$Rep = "SELECT IDInstallation, Nom FROM installation WHERE Nom LIKE '%".$_POST['FORMSearch']."%' ORDER BY Nom ASC";
	$Model = "index.php?Section=Installation_Form&IDInstallation=";
	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->Addoutput(generateSearchResult('Installation',$Rep,$Model),0,0);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
			
	$Rep = "SELECT IDResponsable, concat(Nom,' ',Prenom) FROM responsable WHERE Nom LIKE  '%".$_POST['FORMSearch']."%' OR Prenom LIKE  '%".$_POST['FORMSearch']."%'  ORDER BY Nom ASC";
	$Model = "index.php?Section=Responsable_Form&IDResponsable=";
	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->Addoutput(generateSearchResult('Responsable',$Rep,$Model),0,0);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
		
	$Rep = "SELECT IDEmploye, concat(Nom,' ',Prenom) FROM employe WHERE Nom LIKE  '%".$_POST['FORMSearch']."%' OR Prenom LIKE  '%".$_POST['FORMSearch']."%'  ORDER BY Nom ASC";
	$Model = "index.php?Section=Employe&IDEmploye=";
	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->Addoutput(generateSearchResult('Employé',$Rep,$Model),0,0);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	}
	
	
	echo $MainOutput->Send(1);
	

	
?>