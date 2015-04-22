<?PHP

SWITCH($Section){

	CASE "Date_Lookup":{
		include('datelookup_form.php');
	BREAK;
	}
 
        
	
	CASE "Client_Form":{
		include('client_form.php');
	BREAK;
	}

	CASE "Next_WorkingDay":{
		include('display_nextworkingday.php');
	BREAK;
	}

	CASE "Search":{
		include('search.php');
	BREAK;
	}


	CASE "Message":{
		include('message.php');
	BREAK;
	}
	
	CASE "Vars":{
		include('modif_vars_form.php');
	BREAK;
	}
	
	
	CASE "Bottin_Responsable":{
		include('bottinresponsable.php');
	BREAK;
	}
	
	CASE "Generate_InspectionReport":{
		include('generate_inspectionreport.php');
	BREAK;
	}

	CASE "ArchivesFacturation":{
		include('display_archivesfacturation.php');
	BREAK;
	}

	
	CASE "Client_DossierFacturation":{
		include('client_dossierfacturation2.php');
	BREAK;
	}

	
	
	CASE "Mail_Horaire":{
		include('mail_horaire.php');
		BREAK;
	BREAK;
	}
	
	CASE "PlanifieInspection":{
		include('inspectionplanifie.php');
		BREAK;
	}
	
	CASE "Inspection":{
		include('inspection.php');
		BREAK;
	}
	
	
	CASE "AddInspection":{
		include('form_inspection.php');
		BREAK;
	}
	
	CASE "SuiviInspection":{
		include('suivi_inspection.php');
		BREAK;
	}
	
	
	CASE "SuperAdmin":{
		include('form_superadmin.php');
	BREAK;
	}
	
	CASE "Message_Form":{
		include('message_form.php');
	BREAK;
	}
	
	CASE "ClientComment_Form":{
		include('add_clientcomment_form.php');
	BREAK;
	}
	
	CASE "Rapport_ClientComment":{
		include('rapport_clientcomment.php');
	BREAK;
	}
	
	
	CASE "Materiel_Form":{
		include('materiel_form.php');
	BREAK;
	}
	
	CASE "Generate_Shiftsheet":{
		include('generate_shiftsheet.php');
	BREAK;
	}
	
	CASE "Display_Materiel";{
		include('display_materiel.php');
	BREAK;
	}

	CASE "Rapport":{
		include('facturation_rapport.php');
	BREAK;
	}
	
	CASE "Add_Paye":{
		include('paye_form.php');
	BREAK;
	}
	
	CASE "Add_Remplacement":{
		include('add_remplacement_form.php');
	BREAK;
	}
	
	CASE "Calcul_Surf":{
		include('calculate_surf.php');
	BREAK;
	}
	
	
	CASE "Employe_Horshift":{
		include('employe_horshift.php');
	BREAK;
	}
	
	CASE "Employe_Summer":{
		include('employe_Summer.php');
	BREAK;
	}
	
	CASE "Remplacement":{
		include('display_shit.php');
	BREAK;
	}

	CASE "Add_Qualif":{
		include('qualif_employe_form.php');
	BREAK;
	}

    CASE "Default_Client":{
        include('default_client.php');
        BREAK;
    }

    CASE "Client_ActivateInactivate":{
        include('Client_ActiveInactive.php');
        BREAK;
    }



	
	CASE "Paiement":{
		include('paiement_form.php');
	BREAK;
	}	
	
	CASE "Summer_Sheet":{
		include('summer_sheet.php');
	BREAK;
	}	
	
	CASE "Summer_Report":{
		include('summer_employe_report.php');
	BREAK;
	}	
	
	CASE "Calcul_Ferie":{
		include('generate_ferie.php');
	BREAK;
	}	
	
	CASE "Add_Facture":{
		include('facture_form.php');
	BREAK;
	}	
	
	CASE "Modifie_Facture":{
		$Modifie = TRUE;
		include('display_facture.php');
	BREAK;
	}	
	
	CASE "Add_Facture":{
		include('facture_form.php');
	BREAK;
	}	
	
	CASE "BoniCrush":{
		include('bonuscrusher.php');
	BREAK;
	}	
	
	CASE "BoniCrushed":{
		include('bonicrushed.php');
	BREAK;
	}	
	
	CASE "Factsheet":{
		include('factsheet_form.php');
	BREAK;
	}	
	
	CASE "Add_Saison":{
		include('saison_form.php');
	BREAK;
	}
	
	CASE "Generate_Facture":{
		include('generate_facture.php');
	BREAK;
	}
	
	CASE "Generate_Facture_Mensuelle":{
		include('generate_facture_mensuelle_parpiscine.php');
	BREAK;
	}
	
	
	CASE "Generate_Facture_Mensuelle_CurrentMonth":{
		include('generate_facture_mensuelle_parpiscine_currentmonth.php');
	BREAK;
	}
	
	
	
	
	
	CASE "Employe_Report":{
		include('employe_report.php');
	BREAK;
	}
	
	CASE "Employe_Login":{
		include('employe_login.php');
	BREAK;
	}
	
	CASE "Display_Facturation":{
		include('display_facturation.php');
	BREAK;
	}
	
	CASE "Display_Facture":{
		include('display_facture.php');
	BREAK;
	}
	


	CASE "Close_Saison":{
		include('close_saison_form.php');
	BREAK;
	}

	CASE "Copy_Horaire":{
		include('copy_shift.php');
	BREAK;
	}

	CASE "Display_Timesheet":{
		include('display_timesheet.php');
	BREAK;
	}

	CASE "Installation_Form":{
		include('installation_form.php');
	BREAK;
	}
	
	CASE "Ajustement":{
		include('ajustement_form.php');
	BREAK;
	}
	

	CASE "Responsable_Form":{
		include('responsable_form.php');
	BREAK;
	}
	
	CASE "Display_Shift":{
		include('display_shift.php');
	BREAK;
	}
	
	CASE "Display_Shit":{
		include('display_shit.php');
	BREAK;
	}
	
	CASE "Display_Horshift":{
		include('display_horshift.php');
	BREAK;
	}
	
	CASE "Generate_Repport":{
		include('generate_repport.php');
	BREAK;
	}	
	
	CASE "Horaire":{
		include('horaire_form.php');
	BREAK;
	}
	
	
	CASE "Shift_Form":{
		include('shift_form.php');
	BREAK;
	}
	
	CASE "Horshift":{
		include('modifie_horshift.php');
	BREAK;
	}	
	
	CASE "Modifie_Horaire":{
		include('modifie_horaire.php');
	BREAK;
	}
	
	CASE "Display_Client":{
		include('display_client.php');
		BREAK;
	}
	
	CASE "Employe":{
		include('employe_form.php');
		BREAK;
	}
	
	
	CASE "Add_Shift":{
		include('add_shift.php');
		BREAK;
	}
	
	
	CASE "Horshift_Form":{
		include('horshift_form.php');
		BREAK;
	}
	
	CASE "Generate_Day":{
		include('generate_day.php');
		BREAK;
	}
	
	CASE "EmployeList":{
		include('generate_employe_list.php');
		BREAK;
	}
	
	CASE "EmployeEmailList":{
		include('generate_employe_emaillist.php');
		BREAK;
	}
	
	CASE "TimeSheet":{
		include('generate_timesheet.php');
		BREAK;
	}

	CASE "Conf_Shift":{
		include('conf_shift.php');
		BREAK;
	}	

	CASE "ByPass":{
		include('bypass.php');
		BREAK;
	}
	
	CASE "Display_AskedRemplacement":{
		include('display_askedremplacement.php');
		BREAK;
	}	

	
		CASE "Test":{
		include('test.php');
		BREAK;
	}
	
	

}

?>
