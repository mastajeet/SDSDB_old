<?PHP
$MainOutput->OpenTable();


		
		$MainOutput->OpenRow();
		$MainOutput->OpenCol();
			$MainOutput->AddTexte('Mon horaire des derniers temps','Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
	$Semaine = get_last_sunday(7);
	
	
		$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddOutput(get_employe_horaire($_GET['IDEmploye'],array($Semaine,$Semaine+1*60*60*24*7,$Semaine+2*60*60*24*7,$Semaine+3*60*60*24*7,$Semaine+4*60*60*24*7,$Semaine+5*60*60*24*7,$Semaine+6*60*60*24*7,$Semaine+7*60*60*24*7,$Semaine+8*60*60*24*7,$Semaine+9*60*60*24*7,$Semaine+10*60*60*24*7)),0,0);
	
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();



	$MainOutput->CloseTable();
	echo $MainOutput->Send(1);

?>