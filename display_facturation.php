<?PHP
const AMOUNT_PAID = " $ (payé)";
const BALANCE_IN_ERROR = 'Débalance';
const DETAIL = 'Détail';
const DEPOSIT = 'Dépot';
const BILLED_TO = 'Facturé à: ';
const PAID = 'Payé';
if(isset($_GET['Cote'])){
    $current_cote = $_GET['Cote'];
	$MainOutput->OpenTable();
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('60%',5);
	if($_GET['ToPrint']){
		$MainOutput->AddPic('logo.jpg');
		$MainOutput->br();
	}

	$MainOutput->AddTexte('Installation(s): ','Titre');
	$MainOutput->AddTexte($installationListInString);
	$MainOutput->br();
	$MainOutput->AddTexte('Cote: ','Titre');
	$MainOutput->AddTexte($current_cote);
	$MainOutput->br();	
	$InfoClicli = get_client_info_bycote($current_cote);
	if(!$_GET['ToPrint']){
		if($InfoClicli['Depot']<>0){
	
			$MainOutput->Addlink('index.php?Section=Client_Form&IDClient='.$InfoClicli['IDClient'], DEPOSIT,'_BLANK','Titre');
			if($InfoClicli['DepotP'])
				$MainOutput->AddTexte(": ".number_format($InfoClicli['Depot'],2). AMOUNT_PAID);
			else
				$MainOutput->AddTexte(": ".number_format($InfoClicli['Depot'],2)." $",'Warning');
			}else{
			$MainOutput->Addlink('index.php?Section=Client_Form&IDClient='.$InfoClicli['IDClient'], DEPOSIT,'_BLANK','Titre');
				$MainOutput->AddTexte(": Aucun");
			}
		}
		$MainOutput->br(2);

	if(!isset($_GET['Year'])){
        $current_year = date("Y", time());
	}else{
        $current_year = $_GET['Year'];
	}


	$dossier_facturation = new DossierFacturation($current_cote, $current_year);
	$paiements = $dossier_facturation->get_all_payments();

    	$total_to_pay = $dossier_facturation->get_total_to_be_paid();
		$balance_details = $dossier_facturation->get_balance_details();
		$total = $total_to_pay['total'];
			if(!$_GET['ToPrint']){
				$MainOutput->AddTexte('Sommaire','Titre');

                $MainOutput->br();

				$MainOutput->AddTexte('Sous-Total: ','Titre');
				$MainOutput->AddTexte(number_format($total_to_pay["sub_total"],2)." $");
                $MainOutput->br();
				$MainOutput->AddTexte('TPS: ','Titre');
				$MainOutput->AddTexte(number_format($total_to_pay["tps"],2)." $");
                $MainOutput->br();
				$MainOutput->AddTexte('TVQ: ','Titre');
				$MainOutput->AddTexte(number_format($total_to_pay["tvq"],2)." $");
				$MainOutput->br();
				$MainOutput->AddTexte('-------------------','Titre');
				$MainOutput->br();
				$MainOutput->AddTexte('Total: ','Titre');

				$MainOutput->AddTexte(number_format($total_to_pay["total"],2)." $");
				$MainOutput->AddLink('index.php?Section=Paiement&Cote='.$current_cote.'&Year='.$current_year, PAID,'','Titre');
				$MainOutput->AddTexte(": ".number_format($balance_details['total_paid'],2)." $");

				$MainOutput->br();
				$MainOutput->AddTexte('-------------------','Titre');
				$MainOutput->br();
			}
		$MainOutput->AddTexte('Solde: ','Titre');
		$MainOutput->AddTexte(number_format($balance_details["balance"],2)." $");

		$MainOutput->CloseCol();

		$MainOutput->OpenCol('',3);

		$customer = Customer::find_customer_by_cote($current_cote );
		$Req2 = "SELECT client.`Nom`, client.`Adresse`, client.`Facturation`, client.`Fax`, client.`Email`, responsable.`Nom`, responsable.Prenom, client.Tel FROM installation join client join responsable on installation.IDClient = client.IDClient AND client.RespF = responsable.IDResponsable WHERE installation.Cote = '".$current_cote."'";
		$SQL->SELECT($Req2);
		$Rep = $SQL->FetchArray();
		$MainOutput->AddTexte(BILLED_TO,'Titre');
				$MainOutput->AddTexte($customer->Nom);
				$MainOutput->br();
				$MainOutput->AddTexte('A/S: ','Titre');
				$MainOutput->AddTexte($Rep[6]." ".$Rep[5]." ");
				$MainOutput->br();
				$MainOutput->AddTexte('Tel.: ','Titre');
				$MainOutput->AddTexte("(".substr($Rep[7],0,3).") ".substr($Rep[7],3,3)."-".substr($Rep[7],6,4));
							if(strlen(substr($Rep[7],10,4))>1)
								$MainOutput->AddTexte(" #".substr($Rep[7],10,4));
				$MainOutput->br();
				$MainOutput->AddTexte($Rep[1]);
				$MainOutput->br();
					if($Rep[2]=="E"){
						$MainOutput->AddTexte('Email: ','Titre');
						$MainOutput->AddTexte($Rep[4]);
					}
					if($Rep[2]=="F")
						$MainOutput->AddTexte("<b>Fax.</b>: (".substr($Rep[3],0,3).") ".substr($Rep[3],3,3)."-".substr($Rep[3],6,4));

		$MainOutput->CloseCol();


		$MainOutput->CloseRow();
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',8);
		$MainOutput->br();

			$MainOutput->AddTexte(DETAIL,'Titre');
		if(!$_GET['ToPrint']){
			$MainOutput->addlink('index.php?Section=Add_Facture&Cote='.$_GET['Cote'], '<img border=0 src=assets/buttons/b_ins.png title="Créer une facture manuelle">');
			$MainOutput->addlink('index.php?Section=DossierFacturation_DisplayAccountStatement&Cote='.$_GET['Cote'].'&ToPrint=TRUE&number_of_shown_transactions=15', '<img border=0 src=assets/buttons/b_print.png title="Imprimer le dossier de facturation">','_BLANK');
			$MainOutput->addlink('index.php?Section=ArchivesFacturation&Cote='.$_GET['Cote'],'<img border=0 src=f_close.png title="Archive des dossiers de facturation">');
			$MainOutput->addlink('index.php?Section=Invoice_GenerateInterestInvoice&Cote='.$_GET['Cote'].'&Year='.$current_year, '<img border=0 src=assets/buttons/b_monte.png title="Create Interest Invoice Charge">');
		}


		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$MainOutput->OpenRow();
			$MainOutput->OpenCol(20);
				$MainOutput->AddTexte(' ');
			$MainOutput->CloseCol();
			$MainOutput->OpenCol(50);
				$MainOutput->AddTexte('Date','Titre');
			$MainOutput->CloseCol();
			$MainOutput->OpenCol(25);
				$MainOutput->AddTexte('Fac','Titre');
			$MainOutput->CloseCol(100);
				$MainOutput->OpenCol();
				$MainOutput->AddTexte('Sous-Total','Titre');
			$MainOutput->CloseCol(50);
				$MainOutput->OpenCol();
				$MainOutput->AddTexte('TPS','Titre');
			$MainOutput->CloseCol();
				$MainOutput->OpenCol(50);
				$MainOutput->AddTexte('TVQ','Titre');
			$MainOutput->CloseCol();
				$MainOutput->OpenCol(100);
				$MainOutput->AddTexte('Total','Titre');
			$MainOutput->CloseCol();
				$MainOutput->OpenCol(20);
				$MainOutput->AddTexte(AMOUNT_PAID,'Titre');
			$MainOutput->CloseCol();
		$MainOutput->CloseRow();

		$factures = $dossier_facturation->get_all_factures();

		foreach($factures as $id_facture =>$facture){
            $facture_date =  new DateTime("@".$facture->EnDate);

			$MainOutput->OpenRow();
			$MainOutput->OpenCol();
					if(!$_GET['ToPrint']){
						$MainOutput->AddLink('index.php?Section=Invoice_Show&invoice_id='.$id_facture.'&ToPrint=TRUE', '<img src=assets/buttons/b_print.png border=0 title="Imprimer la facture">','_BLANK','Texte');
						$MainOutput->AddLink('index.php?Section=Invoice_Show&edit=1&invoice_id='.$id_facture, '<img src=assets/buttons/b_edit.png border=0 title="Modifier la facture">','','Texte');
					}
			$MainOutput->CloseCol();
			$MainOutput->OpenCol();

			$MainOutput->AddTexte($facture_date->format("d-m-Y"));

			$MainOutput->CloseCol();
			$MainOutput->OpenCol();
			$Class = 'Warning';
			if($facture->is_paid() || $facture->is_credit())
				$Class = 'Titre';
			$sequence_prefix='';
				if($facture->is_credit()){
					$sequence_prefix='c';
				}elseif($facture->is_avance_client()){
					$sequence_prefix='a';
				}
				$facture_detail = $facture->get_balance();
				$MainOutput->AddTexte($sequence_prefix.$facture->Cote."-".$facture->Sequence,$Class);
			$MainOutput->CloseCol();
				$MainOutput->OpenCol();
				$MainOutput->AddTexte(number_format($facture_detail['sub_total'],2)." $");
			$MainOutput->CloseCol();
				$MainOutput->OpenCol();
				$MainOutput->AddTexte(number_format($facture_detail['tps'],2)." $");
			$MainOutput->CloseCol();
				$MainOutput->OpenCol();
				$MainOutput->AddTexte(number_format($facture_detail['tvq'],2)." $");
			$MainOutput->CloseCol();
				$MainOutput->OpenCol();
				$MainOutput->AddTexte(number_format($facture_detail['total'],2)." $");
			$MainOutput->CloseCol();
				$MainOutput->OpenCol();

				if($facture->is_credit())
					$MainOutput->AddTexte('N/A','Titre'); //METTRE LA DATE OU ENCORE LE NUM?RO DE D?POT OU LE NUM?RO DE CHEQUE...
				elseif($facture->is_paid() && !$facture->is_credit()){
                    $payement = $facture->get_payment($paiements);
					$MainOutput->AddTexte($time_service->format_timestamp($payement->Date, "d F Y"));
				}

			$MainOutput->CloseCol();
			$MainOutput->CloseRow();

		}
		$MainOutput->CloseTable();
	}else{
		$MainOutput->AddForm('Ouvrir le dossier de Facturation','index.php','GET','');
		$SQL = new sqlclass;

    $installationCotes = $installationService->getInstallationsCotes();
        $options = array();
		foreach($installationCotes as $cote){
            $installationListInString = $installationService->getInstallationListInStringByCote($cote,true,true);
            $options[$cote] = $cote.": ".$installationListInString;
		}

		$MainOutput->inputhidden_env('Section','Display_Facturation');
		$MainOutput->inputselect('Cote',$options);
		$MainOutput->FormSubmit('Ouvrir');
}


echo $MainOutput->Send(1);
