 <?PHP
$SQL = new sqlclass;
$SQL2 = new sqlclass;
$Req = "SELECT IDFacture, Sequence,Semaine FROM facture WHERE !Paye AND Cote='".$_POST['Cote']."' ORDER BY Sequence ASC";
$SQL->SELECT($Req);
$Paid = "~";
$paiement_day = $_POST['FORMDate5'];
$paiement_month = $_POST['FORMDate4'];
$paiement_year = $_POST['FORMDate3'];


if($paiement_day==""){
    $paiement_timestamp = $time_service->get_today_timestamp();
}
else
	$paiement_timestamp = $time_service->get_date_timestamp($paiement_month, $paiement_day, $paiement_year);


$UpdateQueries = array();
$FactureSameYear = TRUE;

while($Rep = $SQL->FetchArray()){
	if(isset($_POST['FORMToPay'.$Rep[0]])){
            if(!isset($FactureFirstYear))
                $FactureFirstYear = date("Y",$Rep['Semaine']);
            if($FactureFirstYear==date("Y",$Rep['Semaine'])){
                   
                $Paid = $Paid.$_POST['Cote']."-".$Rep[1]."~";
		$UpdateQueries[] = "UPDATE facture SET Paye=1 WHERE IDFacture=".$Rep[0];
		
                }else{
                $FactureSameYear=FALSE;
            }
	}
}


if($FactureSameYear){

    if(isset($FactureFirstYear)){
        $PayableYear = $FactureFirstYear;
    }else{
        $PayableYear = intval($_POST['FORMPayableYear']);
    }

    foreach($UpdateQueries as $Req){
        $SQL2->QUERY($Req);
    }
        
    $Montant = floatval(str_replace(',','.',$_POST['FORMMontant']));
    $Notes = $_POST['FORMNotes']." Paye:".$Paid;
    $Req2 = "INSERT INTO paiement(`Cote`,`Montant`,`Notes`,`PayableYear`,`Date`) VALUES('".$_POST['Cote']."',".$Montant.",'".addslashes($Notes)."',".$PayableYear.",".$paiement_timestamp.")";
    $SQL->INSERT($Req2);
    $MainOutput->AddTexte('Paiement ajouté','Warning');
}else{
    
    $MainOutput->AddTexte('Les factures sélectionnées ne sont pas sur les mêmes années de facturation. Veuillez scinder le paiement afin d\'assurer la cohérence du dossier de facturation','Warning');
}



?>