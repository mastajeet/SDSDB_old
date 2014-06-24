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
$MainOutput->addpic('carlos.gif','height=30');
$MainOutput->CloseCol();
$MainOutput->CloseRow();




$MainOutput->OpenRow();
		$MainOutput->OpenCol();
			$MainOutput->AddTexte('Mon horaire futur avec Remplacement','Titre');
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

#Ajout 24 juin 2014 - 1 mois d'historique sur les horaire


$MainOutput->OpenRow();
$MainOutput->OpenCol();
$MainOutput->addpic('carlos.gif','height=30');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->OpenRow();
$MainOutput->OpenCol();
$MainOutput->AddTexte('Mon horaire passé','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();



$SemainePreformat = array();
$SemainePreformat[2] = get_last_sunday(1);
$SemainePreformat[1]= get_last_sunday(0, $SemainePreformat[2]-3600);
$SemainePreformat[0]= get_last_sunday(0, $SemainePreformat[1]-3600);






$Semaine = array($SemainePreformat[2],$SemainePreformat[1],$SemainePreformat[0]);



$MainOutput->OpenRow();
$MainOutput->OpenCol();
$MainOutput->AddOutput(get_employe_horaire($_GET['IDEmploye'],$Semaine),0,0);
$MainOutput->CloseCol();
$MainOutput->CloseRow();





	$MainOutput->CloseTable();
	echo $MainOutput->Send(1);

?>