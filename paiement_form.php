<?PHP
$SQL = new sqlclass;

$current_cote = $_GET['Cote'];

if(isset($_GET['ADD']) && $_GET['ADD']==TRUE){
	if(isset($current_cote)){
		$MainOutput->AddForm('Ajouter un paiement');
		$MainOutput->inputhidden_env('Action','Paiement');
		$MainOutput->inputhidden_env('Cote', $current_cote);
		$Req = "SELECT IDFacture, Sequence FROM facture WHERE !Paye AND !Credit AND Cote='". $current_cote ."' ORDER BY Sequence ASC";
		$SQL->SELECT($Req);
		$opt = array();
		while($Rep = $SQL->FetchArray())
			$opt[$Rep[0]] = $current_cote ."-".$Rep[1];
		
                $MainOutput->InputText('Montant',$Rep['TXH'],6);
		$MainOutput->FlagList('ToPay',$opt,'','Factures');
        $MainOutput->InputTime('Date','Date',0,array('Date'=>TRUE,'Time'=>FALSE));
        $MainOutput->InputText('PayableYear','Année de facturation',4,get_vars("BoniYear"));
        $MainOutput->InputText('Notes',$Rep['Notes']);
		$MainOutput->formsubmit('Effectuer');
	}
}else{

if(!isset($_GET['Year']) or $_GET['Year']=="")
	$current_year = intval(Date("Y"));
else
	$current_year =$_GET['Year'];
	
	
$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('',3);
	$MainOutput->AddTexte('Détail des paiements');
	$MainOutput->br();
	$MainOutput->AddLink('index.php?Section=Paiement&ADD=TRUE&Cote='. $current_cote,'Ajouter un paiement');
	$MainOutput->br();
	$MainOutput->AddLink('index.php?Section=Display_Facturation&Cote='. $current_cote,'Retour au dossier de facturation');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->OpenRow();
$MainOutput->OpenCol();
	$MainOutput->AddTexte('Date','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol();
	$MainOutput->AddTexte('Montant','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol();
	$MainOutput->AddTexte('Détail','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

    $dossier_facturation = new DossierFacturation($current_cote, $current_year);

	$Req = "SELECT `Sequence`, round(round(STotal*(1+TPS),2)*(1+TVQ),2) as Total FROM facture WHERE Cote='". $current_cote ."' and !Credit and semaine>=".mktime(0,0,0,1,1,$current_year)." and semaine<".mktime(0,0,0,1,1,$current_year+1);
	$SQL->SELECT($Req);
		$IDFactureStr ="AND (0 ";
                $FactureTotal = array();
	while($Rep = $SQL->FetchArray()){
		$IDFactureStr .= "OR Notes LIKE '%~". $current_cote ."-".$Rep[0]."~%'";
                $FactureTotal[$Rep['Sequence']]=$Rep['Total'];
	}
	$IDFactureStr .= ")";
	$Req = "SELECT Date, Montant, Notes FROM paiement WHERE Cote = '". $current_cote ."' ".$IDFactureStr." ORDER BY Date DESC";
	$SQL->SELECT($Req);
    $payments = $dossier_facturation->get_all_payments();
	foreach($payments as $id_payment => $payment){
        $MainOutput->OpenRow();
        $MainOutput->OpenCol();
        $MainOutput->addTexte($time_service->format_timestamp($payment->Date,"d F Y"));
        $MainOutput->CloseCol();
        $MainOutput->OpenCol();
        $MainOutput->AddTexte(number_format($payment->Montant,2)."&nbsp;$");
        $MainOutput->CloseCol();

        $factures_paid_with_payment = $payment->get_paid_facture();
        $payment_unbalance = $payment->get_payment_balance($factures_paid_with_payment);

        $MainOutput->OpenCol();
        if(abs($payment_unbalance)> 0.01){
            $MainOutput->AddTexte("<span class=Warning>Débalance: ". number_format($payment_unbalance,2)."</span>");
        }

        $payment_has_balance = stristr($payment->Notes,'balance');

        if($payment_has_balance){
            $paye_section = stristr($payment->Notes,'Paye');
            $paye_section_length = strlen($paye_section);
            $notes_total_length = strlen($this->Notes);
            $balance_section_length = $notes_total_length - $paye_section_length;

            $bolded_balance_section =  "<b>".substr($this->Notes,0,$balance_section_length)."</b>";
            $payments->Notes = $bolded_balance_section." ".$paye_section;
        }

        $MainOutput->AddTexte($payment->Notes);
        $MainOutput->CloseCol();
	    $MainOutput->CloseRow();
    }

	$MainOutput->CloseTable();
}
echo $MainOutput->Send(1);
?>