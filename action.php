<?PHP
const RESPONSABLE_ADDED = 'Reponsable ajouté';
const RESPONSABLE_MODIFIED = 'Responsable modifié';
const EMPLOYEE_ADDED = 'Employé ajouté';
const CUSTOMER_MODIFIED = 'Client modifié';
const CUSTOMER_ADDED = 'Client ajouté';
const MODIFIED = '</b> Modifiée';
const PAYMENT_MODIFIED = 'Paiement modifié';
const SHIFT_MODIFIED = 'Shifts modifiés';
const SHIFT_DELETED = 'Shifts supprimes';
const COMMENT_ADDED = 'Commentaire ajouté';
const MESSAGE_MODIFIED = 'Message modifié';
const MESSAGE_ADDED = 'Message ajouté';
const BILL_MARKED_AS_UNPAID = 'Facture marquée comme inpayée';
const BILL_MARKED_AS_PAID = 'Facture marquée comme payée';
const ITEM_MODIFIED = 'Item modifié';
const ITEM_ADDED = 'Item ajouté';
const SEASON_ADDED = 'Saison ajoutée';
const SEASON_CLOSED = 'Saison fermée';
const SHIFT_CONFIRMED = 'Heures de travail confirmées';
const INSTALLATION_MODIFIED = 'Installation modifiée';
const INSTALLATION_ADDED = 'Installation ajoutée';
const EMPLOYEE_MODIFIED = 'Employé modifié';

SWITCH($Action){
	CASE "Client":{
		if($_POST['Update']){
			include('modifie_client_script.php');
			$MainOutput->AddTexte(CUSTOMER_MODIFIED,'Warning');
		}else{
			include('add_client_script.php');
			$MainOutput->AddTexte(CUSTOMER_ADDED,'Warning');
		}

	BREAK;
	}


    CASE "Delog":{
        setcookie('IDEmploye','',0);
        setcookie('CIE','',0);
        setcookie('CIESDS','',0);
        setcookie('MP','',0);
        setcookie('Bureau','',0);
        setcookie(Authorization::KEY_AUTHORIZATION_LEVEL,'',0);
        setcookie(Authorization::KEY_PASSWORD,'',0);

            ?>
        <script>
        window.location = 'index.php';
        </script>
            <?PHP
    BREAK;
    }

	CASE "ModifieVars":{
		include('modifievars_script.php');
		$MainOutput->AddTexte('Variable <b>'.$_POST['Vars']. MODIFIED,'Warning');
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
//        if($_POST['UPDATE'])
//            include('modifie_inspection_script.php');
//        else
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
        if($authorization->verifySuperAdmin($_COOKIE)) {

            $Date = mktime(0, 0, 0, $_POST['FORMDate4'], $_POST['FORMDate5'], $_POST['FORMDate3']);
            modifie_paiement($_POST['IDPaiement'], $_POST['FORMMontant'], $Date, $_POST['FORMNotes']);
            $MainOutput->AddTexte(PAYMENT_MODIFIED, 'Warning');
            $_GET['Section'] = "SuperAdmin";
        }
        BREAK;
	}

    CASE "delete_payment":{
        $payment_id = $_GET['IDPaiement'];
        if(isset($_GET['Confirmation'])){
        $payment = new Payment($payment_id);
        $payment_service->delete_payment($payment);
        }else{
            $confirmation_link = $_SERVER['REQUEST_URI']."&Confirmation=True";
            $WarningOutput->addlink($confirmation_link, "confimer suppression", "","Warning");
        }
        $Section = "Paiement";
        BREAK;
    }


	CASE "Modifie_Facture_CoteSeq":{
        if($authorization->verifySuperAdmin($_COOKIE)) {

            $MainOutput->AddTexte(modifie_facture_coteseq($_POST['FORMInitial'], $_POST['FORMFinal']), 'Warning');
            $_GET['Section'] = "SuperAdmin";
        }
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
        if($authorization->verifySuperAdmin($_COOKIE)) {
            include('batch_update_script.php');
            $MainOutput->AddTexte(SHIFT_MODIFIED, 'Warning');
            $_GET['Section'] = "SuperAdmin";
        }
        BREAK;
    }


    CASE "Batch_Delete":{
        if($authorization->verifySuperAdmin($_COOKIE)) {

            include('batch_delete_script.php');
            $MainOutput->AddTexte(SHIFT_DELETED, 'Warning');
            $_GET['Section'] = "SuperAdmin";
        }
        BREAK;
    }


	CASE "Add_ClientComment":{

			include('add_clientcomment_script.php');
			$MainOutput->AddTexte(COMMENT_ADDED,'Warning');
			$info = get_installation_info($_POST['FORMIDInstallation']);
			$_GET['MenuClient']= $info['IDClient'];

	BREAK;
	}
	CASE "Message":{
		if($_POST['Update']){
			include('modifie_message_script.php');
			$MainOutput->AddTexte(MESSAGE_MODIFIED,'Warning');
		}else{
			include('add_message_script.php');
			$MainOutput->AddTexte(MESSAGE_ADDED,'Warning');
		}
		$_GET['Section'] = "Message";
	BREAK;
	}

	CASE "MarkUnpayee":{
        if($authorization->verifySuperAdmin($_COOKIE)) {

            $Cote = explode('-', $_POST['FORMCote']);
            $Req2 = "SELECT IDFacture FROM facture WHERE Cote = '" . $Cote[0] . "' AND Sequence=" . $Cote[1];
            $SQL->SELECT($Req2);
            $Rep2 = $SQL->FetchArray();
            mark_unpaid($Rep2[0]);
            $MainOutput->AddTexte(BILL_MARKED_AS_UNPAID, 'Warning');
            $_GET['Section'] = "SuperAdmin";
        }
	BREAK;
	}

	CASE "MarkPayee":{
        if($authorization->verifySuperAdmin($_COOKIE)){
            mark_paid($_POST['IDFacture'],$_POST['FORMIDPaiement']);
            $_GET['Section'] = "SuperAdmin";
            $MainOutput->AddTexte(BILL_MARKED_AS_PAID,'Warning');
        }
	BREAK;
	}

	CASE "Materiel":{
		if($_POST['Update']){
			include('modifie_materiel_script.php');
			$MainOutput->AddTexte(ITEM_MODIFIED,'Warning');
		}else{
			include('add_materiel_script.php');
			$MainOutput->AddTexte(ITEM_ADDED,'Warning');
		}
	BREAK;
	}


    CASE "KimobyCSV_Generate":{
        $now = time();
        $date_time = new DateTime("@".$now);
        $shifts = shift::getAllShiftsRunningAtAnInstant($date_time, $time_service);
        $employee_dto_list = array();

        foreach($shifts as $shift)
        {
            $employe = $shift->getWorkingEmployee();
            $employe_dto = array(
                "nom"=>$employe->Nom,
                "prenom"=>$employe->Prenom,
                "cellphone_number"=>$employe->Cell,
                );
            if(!$employe->isNullEmploye()){
                $employee_dto_list[] = $employe_dto; # Ca serait pas pire d'avoir un dto_manager...
            }
        }

        sort($employee_dto_list);

        print(nl2br(renderCSVListEmployeeSummary($employee_dto_list)));
        exit();
    }


	CASE "Add_Facture":{
		include('add_facture_script.php');
		$_GET['Section'] = "Invoice_Show";
        $_GET['edit'] = 1;
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


    CASE "Invoice_GenerateForWeek":{
        include('Invoice_GenerateForWeek.php');
        break;
    }

    CASE "InvoiceItem_Create":
    {
        $invoice_item_dto = InvoiceItemConverter::fromRequestDataToDTO($_POST);

        $invoice_id = $invoice_item_dto["invoice_id"];
        $invoice = InvoiceFactory::getTypedInvoice(new Invoice($invoice_id));
        $invoice_item = InvoiceItemFactory::getTypedInvoiceItemFromDTO($invoice_item_dto, $invoice);

        $invoice_item->save();
        $invoice->addInvoiceItem($invoice_item);
        $invoice->save();

        $_GET['invoice_id'] = $_POST['post_action_id'];
        $_GET['edit'] = 1;
        break;
    }

    CASE "InvoiceItem_Update":
    {
        $invoice_item_dto = InvoiceItemConverter::fromRequestDataToDTO($_POST);

        $invoice_id = $invoice_item_dto["invoice_id"];

        $invoice = InvoiceFactory::getTypedInvoice(new Invoice($invoice_id));
        $invoice_item = InvoiceItemFactory::getTypedInvoiceItemFromDTO($invoice_item_dto, $invoice);
//        print_r($invoice_item);
//        exit();
        if($invoice_item->isEmpty())
        {
            $invoice_item->destroy();
            $invoice->save();
        } else {
            $invoice_item->save();
            $invoice->save();
        }


        $_GET['invoice_id'] = $_POST['post_action_id'];
        $_GET['edit'] = 1;
        break;
    }

    CASE "Invoice_Delete":
    {
        $invoice_id = $_GET['invoice_id'];
        $invoice = InvoiceFactory::getTypedInvoice(new Invoice($invoice_id));
        $cote = $invoice->Cote;

        $invoice->destroy();

        $_GET['Section'] = "DossierFacturation_Show";
        $_GET['Cote'] = $cote;
        break;
    }


	CASE "Factsheet":{
		if($_POST['Update']){
			include('modifie_factsheet_script.php');
		}else{
			include('add_factsheet_script.php');
		}
		update_facture_balance($_POST['IDFacture']);
		$_GET['Section'] = "Modifie_Facture";
		$_GET['IDFacture'] = $_POST['IDFacture'];
	BREAK;
	}

	CASE "Paiement":{
		include('paiement_script.php');

		$Section= "Display_Facturation";
		$_GET['Cote'] = $_POST['Cote'];
		BREAK;
	}

    CASE "Invoice_GenerateInterestInvoice":{

            $start_year = $_POST['FORMStartDate3'];
            $start_month = $_POST['FORMStartDate4'];
            $start_day = $_POST['FORMStartDate5'];
            $interest_rate = $_POST['FORMInterestRate'];
            $IDfactures = $_POST['FORMIDFacture'];

            $start_date = new Datetime();
            $start_date = $start_date->setDate($start_year,$start_month,$start_day);
            $end_date = new Datetime();
            $nb_days = $end_date->diff($start_date);

            #This InterestRate calculation is hardcoded but should change (?!)
            $effective_interest_rate = pow(1. + $interest_rate/100, $nb_days->days/30)-1;

            $today = $time_service->get_today_timestamp();

            $first_invoice = new Invoice(array_keys($IDfactures)[0]);
            $interest_invoice = $invoice_service->generate_blank_facture(array(
                "semaine" => $time_service->get_start_of_week(new DateTime("@".time()))->getTimestamp(),
                "cote" => $first_invoice->Cote,
                "facture_type" => InvoiceService::INTEREST_INVOICE,
                InvoiceService::SEQUENCE_FROM_DTO=>"",
                "taxable" => false
            ));
            $interest_invoice->save();
            foreach($IDfactures as $IDFacture=>$index)
            {
                if($index)
                {
                    $facture = new Invoice($IDFacture);
                    $balance = $facture->get_balance()['total'];
                    $note =  $facture->Cote."-".$facture->Sequence." (".$interest_rate."% pendant ".$nb_days->days." jours)";
                    $amount_charged = $effective_interest_rate * $balance;

                    $invoice_item = CountableInvoiceItem::fromDetails(array(
                        "invoice_id"=>$interest_invoice->IDFacture,
                        "quantity"=>1,
                        "description"=>$note,
                        'unit_cost'=>$amount_charged));

                    $interest_invoice->addInvoiceItem($invoice_item);
                    $invoice_item->save();
                }
            }
            $interest_invoice->save();

            $_GET['invoice_id'] = $interest_invoice->IDFacture;
            $_GET['edit'] = 1;
        break;
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
			$MainOutput->AddTexte(SEASON_ADDED,'Warning');
		}else{
			close_saison($_POST['FORMIDSaison']);
		$MainOutput->AddTexte(SEASON_CLOSED,'Warning');
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
		$MainOutput->AddTexte(SHIFT_CONFIRMED,'Warning');
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
        include('save_installation_script.php');
        if($_POST['Update']){
			$MainOutput->AddTexte(INSTALLATION_MODIFIED,'Warning');
            $_GET['Section'] = "Display_Client";
		}else{
			$_GET['MenuSection']="Horshift";
			$_GET['IDInstallation'] = get_last_id('installation');
			$MainOutput->AddTexte(INSTALLATION_ADDED,'Warning');
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
            $MainOutput->AddTexte(EMPLOYEE_MODIFIED,'Warning');
		}else{
			include('add_employe_script.php');
			$_GET['IDEmploye'] = get_last_id('employe');
			$MainOutput->AddTexte(EMPLOYEE_ADDED,'Warning');
		}
		$_GET['Section'] = "EmployeList";
	BREAK;
	}
	
	
	
	CASE "Responsable":{
		if($_POST['Update']){
			include('modifie_responsable_script.php');
			$MainOutput->AddTexte(RESPONSABLE_MODIFIED,'Warning');
		}else{
			include('add_responsable_script.php');
			$MainOutput->AddTexte(RESPONSABLE_ADDED,'Warning');
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


