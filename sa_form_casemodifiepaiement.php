<?PHP
	IF(ISSET($_GET['FORMCote'])){
		$Date = mktime(0,0,0,$_GET['FORMDate4'],$_GET['FORMDate5'],$_GET['FORMDate3']);
		$Req = "SELECT * FROM paiement WHERE Cote='".$_GET['FORMCote']."' AND Date=".$Date;
		$month = get_month_list('long');
		$SQL->SELECT($Req);
		if($SQL->NumRow()==0){
		$MainOutput->AddTexte("Aucun paiement pour ".$_GET['FORMCote']." en date du ".$_GET['FORMDate5']." ".$month[intval($_GET['FORMDate4'])]." ".$_GET['FORMDate3'],'Warning');
		$MainOutput->AddForm('Sélectionner un paiement','index.php','GET');
		$MainOutput->InputText('Cote','','8');
		$MainOutput->inputhidden_env('Section','SuperAdmin');
		$MainOutput->inputhidden_env('ToDo','Modifie_Paiement');
		$MainOutput->InputTime('Date','Date',0,array('Date'=>TRUE,'Time'=>FALSE));
		$MainOutput->formsubmit('Chercher');
		}else{
		$Info = $SQL->FetchArray();
		$MainOutput->AddForm('Modifier un paiement');
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',2);
		$MainOutput->AddTexte("Paiement pour ".$_GET['FORMCote']." en date du ".$_GET['FORMDate5']." ".$month[intval($_GET['FORMDate4'])]." ".$_GET['FORMDate3'],'Titre');
		$MainOutput->Closecol();
		$MainOutput->CloseRow();
		$MainOutput->inputhidden_env('Action','Modifie_Paiement');
		$MainOutput->inputhidden_env('IDPaiement',$Info['IDPaiement']);
		$MainOutput->InputText('Montant','Montant',6,$Info['Montant']);
		$MainOutput->InputTime('Date','Date',$Date,array('Date'=>TRUE,'Time'=>FALSE));
		$MainOutput->InputText('Notes','Notes','40',$Info['Notes']);
		$MainOutput->formsubmit('Effectuer');
		}
	}else{
		$MainOutput->AddForm('Sélectionner un paiement','index.php','GET');
		$MainOutput->InputText('Cote','','8');
		$MainOutput->inputhidden_env('Section','SuperAdmin');
		$MainOutput->inputhidden_env('ToDo','Modifie_Paiement');
		$MainOutput->InputTime('Date','Date',0,array('Date'=>TRUE,'Time'=>FALSE));
		$MainOutput->formsubmit('Chercher');
	}
	echo $MainOutput->Send(1);
?>