<?PHP
$MainOutput->AddForm('Deleter des shift en batch');
	$MainOutput->inputhidden_env('Action','Batch_Delete');
	$InstallationReq = "SELECT installation.IDInstallation, installation.Nom FROM `installation` WHERE Saison AND Actif ORDER BY installation.Nom ASC";
	$MainOutput->InputSelect('IDInstallation',$InstallationReq,'','Piscine');
	$MainOutput->InputTime('SDate','Date de d�but',0,array('Time'=>False,'Date'=>TRUE));
	$MainOutput->InputTime('EDate','Date de fin',0,array('Time'=>False,'Date'=>TRUE));
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',2);
		$MainOutput->AddTexte('-----------------------------------------------------------------------------------');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();

		$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',2);
		$MainOutput->AddTexte('Conditions','Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
		
		$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddOutput('<input type="checkbox" name=C_Box1 value=C_IDEmploye>',0,0);
		$MainOutput->AddTexte('Employe','Titre');
		$MainOutput->CloseCol();
		
		
		
		$MainOutput->OpenCol();
		$MainOutput->AddOutput('<select name=FORMC_IDEmploye class=inputselect>',0,0);
		$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE !Cessation ORDER BY Nom ASC";
		$SQL->Select($Req);
		while($Rep = $SQL->FetchArray())
			$MainOutput->AddOutput('<option value='.$Rep[0].'>'.$Rep[1].' '.$Rep[2].'</option>',0,0);
		$MainOutput->AddOutput('</select>',0,0);
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
		
		
		$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddOutput('<input type="checkbox" value=C_Start name=C_Box2>',0,0);
		$MainOutput->AddTexte('Heure de d�but','Titre');
		$MainOutput->CloseCol();
		$MainOutput->OpenCol();
			$MainOutput->AddOutput('<input type=text name=FORMC_Time22 size=2 class=inputtext value=0> : <input type=text name=FORMC_Time21 size=2 class=inputtext value=0>',0,0);
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
		
		
		$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddOutput('<input type="checkbox" name=C_Box3 value=C_End >',0,0);
		$MainOutput->AddTexte('Heure de fin','Titre');
		$MainOutput->CloseCol();
		$MainOutput->OpenCol();
			$MainOutput->AddOutput('<input type=text name=FORMC_Time32 size=2 class=inputtext value=0> : <input type=text name=FORMC_Time31 size=2 class=inputtext value=0>',0,0);
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();


$MainOutput->OpenRow();
$MainOutput->OpenCol();
$MainOutput->AddOutput('<input type="checkbox" name=C_Box4 value=C_Assistant>',0,0);
$MainOutput->AddTexte('Assistant','Titre');
$MainOutput->CloseCol();

		$MainOutput->FormSubmit('Modifier');
		echo $MainOutput->Send(1);
?>