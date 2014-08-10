<?PHP
	$MainOutput->AddForm('Modifier des shift en batch');
	$MainOutput->inputhidden_env('Action','Batch_Update');
	$InstallationReq = "SELECT installation.IDInstallation, installation.Nom FROM `installation` WHERE Saison AND Actif ORDER BY installation.Nom ASC";
	$MainOutput->InputSelect('IDInstallation',$InstallationReq,'','Piscine');
	$MainOutput->InputTime('SDate','Date de début',0,array('Time'=>False,'Date'=>TRUE));
	$MainOutput->InputTime('EDate','Date de fin',0,array('Time'=>False,'Date'=>TRUE));
	$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddTexte('Champs à modifier','Titre');
		$MainOutput->CloseCol();
		$MainOutput->OpenCol();
		$MainOutput->AddOutput('<span class=Texte><input type="checkbox" name="Field1" value="IDEmploye">Sauveteur
		<input type="checkbox" name="Field2" value="Start">Heure de début
		<input type="checkbox" name="Field3" value="End">Heure de fin
		<input type="checkbox" name="Field4" value="Salaire">Salaire
		<input type="checkbox" name="Field5" value="TXH">Taux Horaire
		<input type="checkbox" name="Field6" value="Warn">Notes pré-shit');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
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



		$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',2);
		$MainOutput->AddTexte('-----------------------------------------------------------------------------------');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();


		$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',2);
		$MainOutput->AddTexte('Nouvelles valeurs','Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
		$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE !Cessation ORDER BY Nom ASC";
		$MainOutput->InputSelect('IDEmploye',$Req,'','Sauveteur');
		$MainOutput->InputTime('Time2','Heure de d�but',0,array('Time'=>TRUE,'Date'=>FALSE));
		$MainOutput->InputTime('Time3','Heure de fin',0,array('Time'=>TRUE,'Date'=>FALSE));
		$MainOutput->InputText('Salaire','Salaire','4');
		$MainOutput->InputText('TXH','Taux horaire','4');
		$MainOutput->textarea('Warn','Pr�-shit','25','2');
		$MainOutput->FormSubmit('Modifier');
		echo $MainOutput->Send(1);
?>