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
	while($Rep = $SQL->FetchArray()){
        $MainOutput->OpenRow();
        $MainOutput->OpenCol();
            $MainOutput->addTexte($time_service->format_timestamp($Rep[0],"d F Y"));
        $MainOutput->CloseCol();
        $MainOutput->OpenCol();
            $MainOutput->AddTexte(number_format($Rep[1],2)." $");
        $MainOutput->CloseCol();
        $MainOutput->OpenCol();

        $facture_paid_with_payment = explode('~',stristr($Rep[2],'Paye'));
        $sum_of_facture_paid_with_payment = 0;

        foreach($facture_paid_with_payment as $facture){
            $paid_facture_token = stristr($facture,'-');
            if($paid_facture_token and $paid_facture_token!="-") {
                $sum_of_facture_paid_with_payment += $FactureTotal[substr(stristr($facture, '-'), 1)];
            }
        }
      
        if(abs($sum_of_facture_paid_with_payment-$Rep[1])>0.1){
         
            $Debalance = round($sum_of_facture_paid_with_payment-$Rep[1],2);
            $MainOutput->AddTexte("<span class=Warning>Débalance: ". $Debalance."</span>");
        }
	    if(stristr($Rep[2],'balance')){
            $facture_paid_with_payment = stristr($Rep[2],'Paye');
            $PayePlus = strlen($facture_paid_with_payment);
            $Total = strlen($Rep[2]);
            $Balance = $Total-$PayePlus;
            $Engras = "<b>".substr($Rep[2],0,$Balance )."</b>";
            $Rep[2] = $Engras." ".$facture_paid_with_payment;
		
	    }
	
		$MainOutput->AddTexte($Rep[2]);
	
	
	
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	}
	$MainOutput->CloseTable();
}
echo $MainOutput->Send(1);
?>