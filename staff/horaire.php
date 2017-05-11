<?PHP
	
$SemainePreformat = array();
$SemainePreformat[0] = get_last_sunday();
$SemainePreformat[1]= get_next_sunday(0, $SemainePreformat[0]);
$SemainePreformat[2]= get_next_sunday(0, $SemainePreformat[1]);
$SemainePreformat[3]= get_next_sunday(0, $SemainePreformat[2]);
$SemainePreformat[4]= get_next_sunday(0, $SemainePreformat[3]);
$SemainePreformat[5]= get_next_sunday(0, $SemainePreformat[4]);
$SemainePreformat[6]= get_next_sunday(0, $SemainePreformat[5]);
$SemainePreformat[7]= get_next_sunday(0, $SemainePreformat[6]);
$SemainePreformat[8]= get_next_sunday(0, $SemainePreformat[7]);
        
$Semaine = array($SemainePreformat[0],$SemainePreformat[1],$SemainePreformat[2],$SemainePreformat[3]); #,$SemainePreformat[4],$SemainePreformat[5],$SemainePreformat[6],$SemainePreformat[7]);
        
        
        
        
	update_lastvisited($_COOKIE['IDEmploye'],Time());
	$EmplInfo = get_employe_info($_COOKIE['IDEmploye']);
	
	$MainOutput->OpenTable();
		$MainOutput->OpenRow();
		$MainOutput->OpenCol();
			$MainOutput->AddTexte('Mon horaire avec remplacements - '.$EmplInfo['Prenom']." ".$EmplInfo['Nom'],'Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
	
		$MainOutput->OpenRow();
		$MainOutput->OpenCol();
			$MainOutput->AddOutput(get_employe_horaire($_COOKIE['IDEmploye'],$Semaine),0,0);
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
	$MainOutput->CloseTable();
	
	echo $MainOutput->Send(1);
?>