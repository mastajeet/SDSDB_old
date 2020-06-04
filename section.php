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


    CASE "DossierFacturation_DisplayMonthlyTransactions":{

        if(!isset($_GET['FORMyear']) or !isset($_GET['FORMmonth'])) {

            $year = intval(date("Y"));
            $month = intval(date("m"));

            if($month==1){
                $year-=1;
                $month=12;
            }else{
                $month-=1;
            }

            include('view/dossier_facturation/form_monthly_transaction.php');
        }else{
            $year = $_GET['FORMyear'];
            $month = $_GET['FORMmonth'];

            $dossiers_facturation = DossierFacturation::find_all_dossiers_facturation_by_year($year);
            $billed_by_cote = array();
            $paid_by_cote = array();
            $total_billed = 0;
            $total_paid = 0;

            foreach($dossiers_facturation as $cote=>$dossier){
                $factures_of_month = $dossier->get_factures_for_month($month);
                $payments_of_month = $dossier->get_payments_for_month($month);

                $billed = $dossier->sum_all_factures($factures_of_month)['total'];
                $paid = $dossier->sum_all_payments($payments_of_month);
                if($billed>0 or $paid>0){
                    $billed_by_cote[$cote] =$billed;
                    $paid_by_cote[$cote] =$paid;

                    $total_billed += $billed_by_cote[$cote];
                    $total_paid += $paid_by_cote[$cote];
                }
            }

            include('view/dossier_facturation/display_monthly_transactions.php');
        }
        BREAK;
    }

    CASE "DossierFacturation_DisplayAccountStatement":{
        $year = intval(date("Y"));
        $number_of_shown_transactions = 15;
        if(isset($_GET['year'])){
            $year = intval($_GET['year']);
        }
        if(isset($_GET['number_of_shown_transactions'])){
            $number_of_shown_transactions = $_GET['number_of_shown_transactions'];
        }
        if(!isset($_GET['Cote'])){
            $MainOutput->AddTexte(NO_SELECTED_COTE);
        }else{
            $cote = $_GET['Cote'];

            $dossier_facturation = new DossierFacturation($cote, $year);

            $customer_balance = $dossier_facturation->get_balance_details();
            $last_transactions =  $dossier_facturation->get_last_transactions($number_of_shown_transactions);
            $shown_transactions = $last_transactions['transactions'];
            $opening_balance = $last_transactions['opening_balance'];

            $customer = Customer::find_customer_by_cote($cote);
            include('view/dossier_facturation/display_account_statement.php');
        }

        BREAK;
    }



    CASE "Mail_Horaire":{
        include('mail_horaire.php');
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

    CASE "Facture_DisplayFacturationReport":{
        $year_to_display = array();
        $this_year = get_vars("Boniyear");
        $last_year = $this_year-1;
        $two_years_ago = $this_year-2;
        $year_to_display[] = $this_year;
        $year_to_display[] = $last_year;
        $year_to_display[] = $two_years_ago;

        $current_year = (isset($_GET['year']) ? $_GET['year'] : $this_year);

        $customers_with_outstanding_balance = Customer::get_all_customer_with_oustanding_balance($current_year);
        $customer_dtos = array();

        $total_recevable = 0;
        foreach($customers_with_outstanding_balance as $customer){
            $solde = 0;
            foreach($customer->dossier_facturation as $dossier_facturation){
                $solde += $dossier_facturation->get_balance_details()["balance"]; // je devrais mettre une méthode dans le customer qui pogne la balance detail
            }
            $customer_dtos[] = ["name"=>$customer->Nom, "cote"=>$customer->Cote, "balance"=>$solde];
            $total_recevable += $solde;
        }

        include('display_facturation_report.php');
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


    CASE "List_Bureau_Employee":{
        include('list_bureau_employee.php');
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
        include('view/installation/installation_form.php');
        BREAK;
    }

    CASE "Ajustement":{
        include('ajustement_form.php');
        BREAK;
    }




    CASE "generate_free_employees":{
        $horaire_factory = new HoraireFactory($time_service, new SqlClass());

        $last_session = $variable->get_value('Saison');
        $employee_list = Employee::get_employee_list_for_session($last_session);
        $semaine = $_GET['Semaine'];
        $day = $_GET['Day'];

        $day_to_generate = $time_service->get_datetime_from_semaine_and_day(new DateTime("@".$semaine), $day);
        $horaire = $horaire_factory->generate_horaire_for_one_day($day_to_generate);

        $free_employees = $horaire->get_free_employees($employee_list);
        include('generate_free_employee_list.php');
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
        include('display_employe.php');
        BREAK;
    }

    CASE "Modifie_Employe":{
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

    DEFAULT:{
        echo NO_GET_ROUTE_FOUND.$Section;
    }

}

?>

