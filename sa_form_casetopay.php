<?PHP
$MainOutput->OpenTable('400');
$MainOutput->OpenRow();
$MainOutput->OpenCol();
if(isset($_GET['FORMCote'])){
$MainOutput->AddForm('Code de la facture à payer');
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('Facture à marquer comme payée: <b>'.$_GET['FORMCote'].'</b>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
	$Cote = explode('-',$_GET['FORMCote']);
$Req = "SELECT IDPaiement, Date FROM paiement WHERE Cote='".$Cote[0]."' ORDER BY Date DESC";
$SQL->SELECT($Req);


$Opt = array();
while($Rep = $SQL->FetchArray()){
	$Opt[$Rep[0]] = datetostr($Rep[1]);
}
$Req2 = "SELECT IDFacture FROM facture WHERE Cote = '".$Cote[0]."' AND Sequence=".$Cote[1];
$SQL->SELECT($Req2);
$Rep2 = $SQL->FetchArray();
	$MainOutput->inputSelect('IDPaiement',$Opt,'','Date de paiement');
		$MainOutput->InputHidden_ENV('Action','MarkPayee');
		$MainOutput->InputHidden_ENV('IDFacture',$Rep2[0]);
	$MainOutput->Formsubmit('Payée');
}else{
	$MainOutput->AddForm('Code de la facture à payer','index.php',"GET");
	$MainOutput->InputText('Cote','Code',10);
	$MainOutput->InputHidden_env('Section','SuperAdmin');
	$MainOutput->InputHidden_env('ToDo','ToPay');
	$MainOutput->FormSubmit('À Payer');
}

$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->CloseTable();
echo $MainOutput->Send(1);
?>