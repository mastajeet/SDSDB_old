<?PHP
SWITCH($Action){
	CASE "Client":{
		if($_POST['Update']){
			include('modifie_client_script.php');
			$MainOutput->AddTexte('Client modifi�','Warning');
		}else{
			include('add_client_script.php');
			$MainOutput->AddTexte('Client ajout�','Warning');
		}
		
	BREAK;
	}


		CASE "Delog":{
			setcookie('IDEmploye','',0);
			setcookie('CIE','',0);
                        setcookie('CIESDS','',0);
			?>
		<script>
		window.location = 'index.php';
		</script>
			<?PHP
		BREAK;
		}

	CASE "ModifieVars":{
		include('modifievars_script.php');
		$MainOutput->AddTexte('Variable <b>'.$_POST['Vars'].'</b> Modifi�e','Warning');
	BREAK;
	}
	
	
	CASE "Date_Lookup":{
		include('date_lookup_script.php');
				
	BREAK;
	}


        CASE "Delete_Vacances":{
            include('delete_vacances_script.php');
            BREAK;
        }


	CASE "Inspection":{
        if($_POST['UPDATE'])
            include('modifie_inspection_script.php');
        else
            include('add_inspection_script.php');
        BREAK;
    }

	CASE "Generate_FactureInspectiont":{
		include('generate_facturemateriel.php');
	BREAK;
	}
	
	
	
	
	CASE "SuiviInspection":{
		include('suivi_inspection_script.php');
	BREAK;
	}
	
	
	CASE "ChangeEmployeNo":{
		include('change_employeno.php');
	BREAK;
	}
	
	CASE "Modifie_Paiement":{
		$Date = mktime(0,0,0,$_POST['FORMDate4'],$_POST['FORMDate5'],$_POST['FORMDate3']);
		modifie_paiement($_POST['IDPaiement'],$_POST['FORMMontant'],$Date,$_POST['FORMNotes']);
		$MainOutput->AddTexte('Paiement modifi�','Warning');
		$_GET['Section'] = "SuperAdmin";
	BREAK;
	}


	CASE "Modifie_Facture_CoteSeq":{
		$MainOutput->AddTexte(modifie_facture_coteseq($_POST['FORMInitial'],$_POST['FORMFinal']),'Warning');
		$_GET['Section'] = "SuperAdmin";
		
	BREAK;
	}
	
	CASE "PlanifieInspection":{
		if($_POST['UPDATE']){
			include('modifie_planifieinspection_script.php');
		}else{
			include('add_planifieinspection_script.php');
		}
		$_GET['Section']="Inspection";
		$_GET['TODO']=TRUE;
	BREAK;
	}
	

	
	
	CASE "Batch_Update":{
		include('batch_update_script.php');
		$MainOutput->AddTexte('Shifts modifi�s','Warning');
		$_GET['Section'] = "SuperAdmin";
	BREAK;
	}
	
	
	CASE "Add_ClientComment":{
		
			include('add_clientcomment_script.php');
			$MainOutput->AddTexte('Commentaire ajout�','Warning');
			$info = get_installation_info($_POST['FORMIDInstallation']);
			$_GET['MenuClient']= $info['IDClient'];
	
	BREAK;
	}
	CASE "Message":{
		if($_POST['Update']){
			include('modifie_message_script.php');
			$MainOutput->AddTexte('Message modifi�','Warning');
		}else{
			include('add_message_script.php');
			$MainOutput->AddTexte('Message ajout�','Warning');
		}
		$_GET['Section'] = "Message";
	BREAK;
	}

	CASE "MarkUnpayee":{
		$Cote = explode('-',$_POST['FORMCote']);
		$Req2 = "SELECT IDFacture FROM facture WHERE Cote = '".$Cote[0]."' AND Sequence=".$Cote[1];
		$SQL->SELECT($Req2);
		$Rep2 = $SQL->FetchArray();
		mark_unpaid($Rep2[0]);
		$MainOutput->AddTexte('Facture marqu�e comme inpay�e','Warning');
		$_GET['Section'] = "SuperAdmin";
	BREAK;
	}
	
	CASE "MarkPayee":{
		mark_paid($_POST['IDFacture'],$_POST['FORMIDPaiement']);
		$_GET['Section'] = "SuperAdmin";
		$MainOutput->AddTexte('Facture marqu�e comme pay�e','Warning');
	BREAK;
	}

	CASE "Materiel":{
		if($_POST['Update']){
			include('modifie_materiel_script.php');
			$MainOutput->AddTexte('Item modifi�','Warning');
		}else{
			include('add_materiel_script.php');
			$MainOutput->AddTexte('Item ajout�','Warning');
		}
	BREAK;
	}



	
	CASE "Add_Facture":{
		include('add_facture_script.php');
		$_GET['Section'] = "Modifie_Facture";
	BREAK;
	}
	
	
		
	CASE "Add_Remplacement":{
		include('add_remplacement_script.php');
        $_GET['Section'] = "Remplacement";
	BREAK;
	}
	
	
	
	CASE "BoniCrusher":{
		include('bonuscrusher_script.php');
	BREAK;
	}
	
	
	
	CASE "Confirm_Remplacement":{
		include('confirm_remplacement_script.php');
		$_GET['Section'] = "Remplacement";
	BREAK;
	}
	
	CASE "Activate":{
		include('activate.php');
	if(isset($_GET['IDClient']))
		unset($_GET['IDClient']);
	if(isset($_GET['IDInstallation']))
		unset($_GET['IDInstallation']);
	$_GET['MenuCat']= "Client";
	BREAK;
	}
	
	CASE "Factsheet":{
		if($_POST['Update']){
			include('modifie_factsheet_script.php');
		}else{
			include('add_factsheet_script.php');
		}
		update_facture_balance($_POST['IDFacture']);
		$_GET['Section'] = "Modifie_Facture";
		$_GET['IDFacture']=$_POST['IDFacture'];
	BREAK;
	}
	
	CASE "Paiement":{
		include('paiement_script.php');
			
		$Section= "Display_Facturation";
		$_GET['Cote'] = $_POST['Cote'];
		BREAK;
	}
	
	CASE "Shift":{
		include('copy_shift_script.php');
		
		BREAK;
	}
	
	
	CASE "Delete_Facture":{
		include('delete_facture.php');
		
		BREAK;
	}
	
	
	CASE "Add_Qualif":{
		include('qualif_employe_script.php');
		
		BREAK;
	}

	
	CASE "Saison":{
		if(!isset($_POST['FORMIDSaison'])){
			add_saison($_POST['FORMSaison'],$_POST['FORMAnnee']);
			$MainOutput->AddTexte('Saison ajout�e','Warning');
		}else{
			close_saison($_POST['FORMIDSaison']);
		$MainOutput->AddTexte('Saison ferm�e','Warning');
		}
		BREAK;
	}
	
	CASE "Shift":{
		include('copy_shift_script.php');
		
		BREAK;
	}
	
	
	CASE "Delete_Timesheet":{
		include('delete_timesheet.php');
		BREAK;
	}

	CASE "Paye":{
		include('add_paye_script.php');
		BREAK;
	}

	
	CASE "Ajustement":{
		include('ajustement_script.php');
		BREAK;
	}

	CASE "Conf_Shift":{
		include('conf_shift_script.php');
		$MainOutput->AddTexte('Heures de travail confirm�es','Warning');
		BREAK;
	}


	
		CASE "ShiftForm":{
		if($_POST['Update']){
			include('modifie_shift_script.php');
		}else{
			include('add_shift_script.php');
		}
		BREAK;
	}
	
	
	
	
	CASE "Installation":{
		if($_POST['Update']){
			include('modifie_installation_script.php');
			$MainOutput->AddTexte('Installation modifi�e','Warning');
		}else{
			include('add_installation_script.php');
			$_GET['MenuSection']="Horshift";
			$_GET['IDInstallation'] = get_last_id('installation');
			$MainOutput->AddTexte('Installation ajout�e','Warning');
		}

	BREAK;
	}
	 
	 CASE "Horaire":{
		if($_POST['Update']){
			include('modifie_horaire_script.php');
		}else{
			include('add_horaire_script.php');
			$Section = "Horshift";
			$_POST['FORMIDHoraire'] = get_last_id('horaire');
		}
	BREAK;
	}
	
	
	CASE "Employe":{
		if($_POST['Update']){
			include('modifie_employe_script.php');
			$MainOutput->AddTexte('Employ� modifi�','Warning');
		}else{
			include('add_employe_script.php');
			$_GET['IDEmploye'] = get_last_id('employe');
			$MainOutput->AddTexte('Employ� ajout�','Warning');
		}
		$_GET['Section'] = "EmployeList";
	BREAK;
	}
	
	
	
	CASE "Responsable":{
		if($_POST['Update']){
			include('modifie_responsable_script.php');
			$MainOutput->AddTexte('Responsable modifi�','Warning');
		}else{
			include('add_responsable_script.php');
			$MainOutput->AddTexte('Reponsable ajout�','Warning');
		}
	BREAK;
	}
	
	CASE "Horshift":{
		if($_POST['Update']){
			include('modifie_horshift_script.php');
			$Section = "Display_Horshift";
		}else{
			include('add_horshift_script.php');
			$Section = "Display_Horshift";
		}
		$Section = "Horshift";
		$_POST['FORMIDHoraire'] = $_POST['IDHoraire'];
		BREAK;
	}
	
	CASE "Modifie_Horshift":{
		if(isset($_GET['Empty'])){
			$Req = "UPDATE horshift SET IDEmploye = 0 WHERE IDHoraire = ".$_GET['IDHoraire'];
			$_GET['Section'] = "Display_Horshift";
		}
		if(isset($_GET['Reset'])){
			$Req = "DELETE FROM horshift WHERE IDHoraire = ".$_GET['IDHoraire'];
			$_GET['Section'] = "Horshift";
		}
		$SQL = new sqlclass;
		$SQL->Query($Req);
	BREAK;
	}
	
	CASE "Generate_Day":{

		include('generate_day_script.php');
		$Section = "Horshift";
		$_POST['FORMIDHoraire'] = $_POST['IDHoraire'];
		BREAK;
	}
	
}
?>


