<?PHP

if(!isset($_GET['Cote'])){
echo "T'es bin pale!";
}elseif(!isset($_GET['Year'])){

	$Req  = "SELECT min(Semaine), max(Semaine) FROM facture WHERE Cote ='".$_GET['Cote']."' GROUP By Cote";
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	$SemaineCur = $Rep[0];
	$SemaineFin = $Rep[1];
	$YearIni = intval(date("Y",$SemaineCur));
	$YearFin = intval(date("Y",$SemaineCur));
	while($SemaineCur<=$SemaineFin){
		$SemaineCur = $SemaineCur + 60*60*24*7;
		$AnneeCourante = intval(date("Y",$SemaineCur));
			if($AnneeCourante > $YearFin){
				$YearFin =	$AnneeCourante;
			}
	}
	$MainOutput->OpenTable();
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',7);
	$MainOutput->AddTexte('Archives de facturations','Titre');
	$MainOutput->br(2);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->OpenRow();
	
	$MainOutput->OpenCol();
	$MainOutput->AddTexte('Annee','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	$MainOutput->AddTexte('S-Total','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	$MainOutput->AddTexte('TPS','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	$MainOutput->AddTexte('TVQ','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	$MainOutput->AddTexte('Total','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	$MainOutput->AddTexte('Paiement','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	$MainOutput->AddTexte('Débalance','Titre');
	$MainOutput->CloseCol();
	
	$MainOutput->CloseRow();
	$AnneeCourante = $YearIni;
	while($AnneeCourante<=$YearFin){
	$MainOutput->OpenRow();

	$dosier_courant = new DossierFacturation($_GET['Cote'],$AnneeCourante);
    $total_to_be_paid = $dosier_courant->get_total_to_be_paid();
	$detail_solde = $dosier_courant->get_balance_details();
	$paiements =

	$MainOutput->OpenCol();
	$MainOutput->AddLink('index.php?Cote='.$_GET['Cote'].'&Year='.$AnneeCourante,$AnneeCourante);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	$MainOutput->AddTexte(number_format($total_to_be_paid['sub_total'],2)." $");
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	$MainOutput->AddTexte(number_format($total_to_be_paid['tps'],2)." $");
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	$MainOutput->AddTexte(number_format($total_to_be_paid['tvq'],2)." $");
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	$MainOutput->AddTexte(number_format($total_to_be_paid['total'],2)." $");
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	$MainOutput->AddTexte(number_format($detail_solde['total_paid'],2)." $");
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	$MainOutput->AddTexte(number_format($detail_solde['balance'],2)." $");
	$MainOutput->CloseCol();
	
	
	$MainOutput->CloseRow();
	
	
	$AnneeCourante++;
	}
	
	
	
}
echo $MainOutput->Send(1);

?>