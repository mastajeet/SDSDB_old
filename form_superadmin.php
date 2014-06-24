<?PHP
if(!isset($_GET['ToDo'])){
	$MainOutput->OpenTable(400);

	$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddTexte('<div align=center>Modifications Super-Admin</div>','Titre');
		$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	
	$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddLink('index.php?Section=SuperAdmin&ToDo=ToPay','Marquer une facture comme <b>Payée</b>');
		$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddLink('index.php?Section=SuperAdmin&ToDo=ToUnpay','Marquer une facture comme <b>Non-Payée</b>');
		$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddLink('index.php?Section=SuperAdmin&ToDo=Modifie_Facture_CoteSeq','Modifier une cote et sequence de facture');
		$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddLink('index.php?Section=SuperAdmin&ToDo=Modifie_Paiement','Modifier un paiement');
		$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddLink('index.php?Section=SuperAdmin&ToDo=Batch_Update','Modifier des shifts en batch');
		$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddLink('index.php?Section=SuperAdmin&ToDo=ChangeEmployeNo','Modifier un numéro d\'employé');
		$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddLink('index.php?Section=Vars','Modifier une variable');
		$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	
	
	$MainOutput->CloseTable();
}else{

	Switch($_GET['ToDo']){
		CASE "ToPay":{
			include('sa_form_casetopay.php');
		BREAK;
		}
		CASE "ToUnpay":{
			include('sa_form_casetounpay.php');
		BREAK;
		}
		CASE "Modifie_Paiement":{
			include('sa_form_casemodifiepaiement.php');
		BREAK;
		}
		CASE "Batch_Update":{
			include('sa_form_batchupdate.php');
		BREAK;
		}
		CASE "Modifie_Facture_CoteSeq":{
			include('sa_form_factureseq.php');
		BREAK;
		}

		CASE "ChangeEmployeNo":{
			include('sa_change_employeno.php');
		BREAK;
		}
	}

}
echo $MainOutput->Send(1);
?>
