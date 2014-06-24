<?PHP
$MainOutput->OpenTable();
		
		$MainOutput->OpenRow();
		$MainOutput->OpenCol();
			$MainOutput->AddTexte('Mon horaire Hebdomadaire','Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
	
	
	
		$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddOutput(get_employe_horshift($_GET['IDEmploye'],TRUE),0,0);
	
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();

		
		$MainOutput->OpenRow();
		$MainOutput->OpenCol();
			$MainOutput->AddTexte('Mon avec Remplacement','Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
	
		
$SemainePreformat = array();
$SemainePreformat[0] = get_last_sunday();
$SemainePreformat[1]= get_next_sunday(0, $SemainePreformat[0]);
$SemainePreformat[2]= get_next_sunday(0, $SemainePreformat[1]);
$SemainePreformat[3]= get_next_sunday(0, $SemainePreformat[2]);
        
$Semaine = array($SemainePreformat[0],$SemainePreformat[1],$SemainePreformat[2],$SemainePreformat[3]);
        
        
        
	
		$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddOutput(get_employe_horaire($_GET['IDEmploye'],$Semaine),0,0);
	
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();



	$MainOutput->CloseTable();
	echo $MainOutput->Send(1);

?>