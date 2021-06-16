<?PHP

const INSERT_INVOICE_ITEM_FORM_TITLE = "Ajouter un item � la facture {cote_seq}";
const UPDATE_INVOICE_ITEM_FORM_TITLE = "Modifier l'item #{invoice_item_id} de la facture {cote_seq}";
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

    CASE "Invoice_GenerateInterestInvoice":{
        $cote = $_GET['Cote'];
        $year = $_GET['Year'];

        $dossier_facturation = new DossierFacturation($cote,$year);
        $unpaid_factures = $dossier_facturation->get_unpaid_factures();
        include('view/invoice/interest/form_generate_by_cote.php');

        break;
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
            $total_pretax_billed = 0;
            $total_TPS_billed = 0;
            $total_TVQ_billed = 0;
            $total_paid = 0;


            foreach($dossiers_facturation as $cote=>$dossier){
                $factures_of_month = $dossier->get_factures_for_month($month);
                $payments_of_month = $dossier->get_payments_for_month($month);

                $billed_BASE = $dossier->sum_all_factures($factures_of_month)['sub_total'];
                $billed_TPS = $dossier->sum_all_factures($factures_of_month)['tps'];
                $billed_TVQ = $dossier->sum_all_factures($factures_of_month)['tvq'];
                $billed_TOTAL = $dossier->sum_all_factures($factures_of_month)['total'];

                $paid = $dossier->sum_all_payments($payments_of_month);
                if($billed_BASE>0 or $paid>0){
                    $billed_by_cote[$cote] = $billed_BASE;

                    $paid_by_cote[$cote] = $paid;

                    $total_billed += $billed_TOTAL;
                    $total_pretax_billed += $billed_BASE;
                    $total_TPS_billed += $billed_TPS;
                    $total_TVQ_billed += $billed_TVQ;
                    $total_paid += $paid_by_cote[$cote];
                }
            }

            include('view/dossier_facturation/display_monthly_transactions.php');
        }
        BREAK;
    }

    CASE "DossierFacturation_DisplayAccountStatement":{
        $year = intval(date("Y"));
        
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
            $installationListInString = $installationService->getInstallationListInStringByCote($_GET['Cote'],true,true);
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
                $solde += $dossier_facturation->get_balance_details()["balance"]; // je devrais mettre une m�thode dans le customer qui pogne la balance detail
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

    CASE "Add_Remplacement":{ # TODO: changer pour employee service!
        $employeeList = $employeeService->getEmployeSelectList();
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

    CASE "InvoiceItem_Create":
    {
        $invoice_id = $_GET['invoice_id'];

        $invoice = new Invoice($invoice_id);
        $customer = Customer::find_customer_by_cote($invoice->Cote);
        $invoice_item_form_field_renderer_factory = new InvoiceItemFormFieldsRendererFactory($timeService, $itemService);

        $default_hourly_rate = $customer->TXH;
        $form_target = array(
            "route"=>"index.php",
            "action"=>'InvoiceItem_Create',
            "section"=>'Invoice_Show'
        );

        $form_title_renderer = new FormatableString(INSERT_INVOICE_ITEM_FORM_TITLE);
        $fields_renderer = $invoice_item_form_field_renderer_factory->getInsertInvoiceItemFormFieldRenderer($invoice_id);
        $invoice_item_form_renderer = new HTMLPrefillableFormRenderer($form_target,false,"POST",$form_title_renderer,$fields_renderer);

        $content_array = array(
            "cote_seq"=>$invoice->Cote."-".$invoice->Sequence,
            "hourly_rate"=>$default_hourly_rate,
            "post_action_id"=>$invoice_id,
            "invoice_id"=>$invoice_id,
        );

        $invoice_item_form_renderer->buildContent($content_array);
        print($invoice_item_form_renderer->render());

        break;
    }

    CASE "InvoiceItem_Edit":
    {
        $invoice_item_form_field_renderer_factory = new InvoiceItemFormFieldsRendererFactory($timeService, $itemService);
        $invoice_item_id = $_GET['invoice_item_id'];
        $invoice_id = $_GET['invoice_id'];
        $invoice = InvoiceFactory::getTypedInvoice(new Invoice($invoice_id));
        $invoice_item = InvoiceItemFactory::getTypedInvoiceItem($invoice_item_id, $invoice);

        $form_target = array(
            "route"=>"index.php",
            "action"=>'InvoiceItem_Update',
            "section"=>'Invoice_Show'
        );

        $form_title_renderer = new FormatableString(UPDATE_INVOICE_ITEM_FORM_TITLE);
        $fields_renderer = $invoice_item_form_field_renderer_factory->getUpdateInvoiceItemFormFieldRenderer($invoice_id);
        $invoice_item_form_renderer = new HTMLPrefillableFormRenderer($form_target,true,"POST",$form_title_renderer,$fields_renderer);

        $content_array = array(
            "cote_seq"=>$invoice->Cote."-".$invoice->Sequence,
            "invoice_item_id"=>$invoice_item_id,
            "id_to_update"=>$invoice_item_id,
            "post_action_id"=>$invoice_id,
        );

        $content_array = array_merge($content_array, $invoice_item->getDetails());

        $invoice_item_form_renderer->buildContent($content_array);
        print($invoice_item_form_renderer->render());

        break;
    }

    CASE "Factsheet":{


        include('factsheet_form.php');
        BREAK;
    }

    CASE "Add_Saison":{
        include('saison_form.php');
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

    CASE "DossierFacturation_Show":
    CASE "Display_Facturation":{
        if(isset($_GET['Cote'])){
            $installationListInString = $installationService->getInstallationListInStringByCote($_GET['Cote'], true, true);
        }

        include('display_facturation.php');
        BREAK;
    }

    CASE "Invoice_GenerateForWeek":{
        include('Invoice_GenerateForWeek.php');
        break;
    }

    CASE "Invoice_Show":{

        $invoice_id = $_GET['invoice_id'];
        $company = $_COOKIE['CIESDS'];
        $edit = false;
        if(isset($_GET['edit']))
        {
            $edit = true;
        }


        $typed_invoice = InvoiceFactory::getTypedInvoice(new Invoice($invoice_id));
        $customer = Customer::find_customer_by_cote($typed_invoice->Cote);
        $invoice_balance = $typed_invoice->getBalance();
        $invoice_items_summary = $typed_invoice->getInvoiceItemsSummary();
        $dossier_facturation = new DossierFacturation($typed_invoice->Cote, null);
        $billing_responsible_details = $dossier_facturation->getBillingResponsibleDetails();

        $header_renderer_factory = new HeaderRendererFactory($timeService);
        $header_renderer = $header_renderer_factory->getHeaderRenderer($typed_invoice, $customer, $company, $edit);
        $body_renderer_factory = new BodyRendererFactory();
        $body_renderer = $body_renderer_factory->getBodyRenderer($typed_invoice, $edit);
        $footer_renderer = new FooterRenderer($header_renderer->invoice_width);

        $invoice_renderer = new HTMLInvoiceRenderer($header_renderer, $body_renderer, $footer_renderer);
        #BUILT_CONTENT_ARRAY!!!
        $content_array = array();
        $content_array['invoice_id'] = $invoice_id;
        $content_array['cote'] = $typed_invoice->Cote;
        $content_array['sequence'] = $typed_invoice->Sequence;
        $content_array['total_money_billed'] = $invoice_balance["total"];
        $content_array['total_hour_billed'] = $invoice_items_summary["number_of_billed_items"];

        $content_array['billing_datetime'] = new DateTime("@".$typed_invoice->EnDate);
        $content_array['billed_to'] = $billing_responsible_details["customer_name"];

        $content_array['billing_contact'] = $billing_responsible_details["responsible_name"]."<br>".$billing_responsible_details["responsible_address"] ;
        $content_array['billing_period_datetime'] = $typed_invoice->getBeginningOfBillablePeriod();
        $content_array['fax_number'] = $customer->Fax;
        $content_array['email_address'] = $customer->Email;

        $content_array['tps_rate'] = number_format($typed_invoice->TPS * 100,2);
        $content_array['tvq_rate'] = number_format($typed_invoice->TVQ * 100,2);


        $content_array['pretax_total'] = $invoice_balance["sub_total"];
        $content_array['tps_amount'] = $invoice_balance["tps"];
        $content_array['tvq_amount'] = $invoice_balance["tvq"];
        $content_array['total'] = $invoice_balance["total"];

        $content_array['invoice_items'] = array();
        foreach($typed_invoice->Factsheet as $invoice_item)
        {
            $content_array['invoice_items'][] = $invoice_item->getDetails();
        }

        $invoice_renderer->buildContent($content_array);
        print($invoice_renderer->render());

        BREAK;
    }

    CASE "Close_Saison":{
        include('close_saison_form.php');
        BREAK;
    }

    CASE "Copy_Horaire":{ # TODO: Installation - Revoir la logique du join
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
        $horaire_factory = new HoraireFactory($timeService, new SqlClass());

        $last_session = $variable->get_value('Saison');
        $employee_list = $employeeService->getEmployeesForSession($last_session);
        $semaine = $_GET['Semaine'];
        $day = $_GET['Day'];

        $day_to_generate = $timeService->get_datetime_from_semaine_and_day(new DateTime("@".$semaine), $day);
        $horaire = $horaire_factory->generate_horaire_for_one_day($day_to_generate);
        print($employee_list);
        $free_employees = $horaire->get_free_employees($employee_list);
        include('generate_free_employee_list.php');
        BREAK;
    }


    CASE "AddEmployeeAccess":{
        include('sa_form_createemployeeaccess.php');
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

    CASE "Display_Client":{ # customer
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


    CASE "Add_Shift":{ #
        $InstallationList = $installationService->getInstallationSelectList(1, 1);
        include('add_shift.php');
        BREAK;
    }

    CASE "Horshift_Form":{
        $employeeList = $employeeService->getEmployeSelectList();
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

