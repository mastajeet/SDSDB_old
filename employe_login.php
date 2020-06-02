<?PHP
$SQL3 = new sqlclass;
$Req3 = "SELECT IDEmploye FROM employe WHERE Session = 'E07' ORDER BY Nom ASC, Prenom ASC LIMIT 170,45";
$SQL3->SELECT($Req3);
$i=1;
while($Rep3 = $SQL3->FetchArray()){
$_GET['IDEmploye'] = $Rep3[0];
$Info = get_employe_info($_GET['IDEmploye']);
$MainOutput->AddTexte('Pour se connecter au logiciel de gestion','Titre');
$MainOutput->br();
$MainOutput->AddTexte('Pour vous connecter au logiciel de gestion, vous devez aller sur le site:');
$MainOutput->br();
$MainOutput->AddTexte('<u>http://www.servicedesauveteurs.com/gestion/</u>','Titre');
$MainOutput->br();
$MainOutput->AddTexte('Vous devez entrer votre numéro d\'employé et les 3 derniers chiffre de votre numéro d\'assurance sociale');
$MainOutput->br(2);
$MainOutput->AddTexte($Info['Nom']." ".$Info['Prenom'],'Titre');
$MainOutput->br();
$MainOutput->AddTexte('Numéro d\'employé: ','Titre');
$MainOutput->AddTexte($Info['IDEmploye']);
$MainOutput->br();
$MainOutput->AddTexte('3 dernier chiffre NAS: ','Titre');
$MainOutput->AddTexte(substr($Info['NAS'],6,3));

	if($i<>5){
		$MainOutput->br(8);
		$i++;
	}
	else{
		$MainOutput->br(5);
		$i=1;
	}

}

echo $MainOutput->Send(1);
?>