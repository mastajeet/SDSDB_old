 <?PHP
$SQL = new sqlclass;
$SQL2 = new sqlclass;
$Req = "SELECT IDFacture, Sequence,Semaine FROM facture WHERE !Paye AND Cote='".$_POST['Cote']."' ORDER BY Sequence ASC";
$SQL->SELECT($Req);
$Paid = "~";

if($_POST['FORMDate5']=="")
	$Time = time();
else
	$Time = mktime(0,0,0,$_POST['FORMDate4'],$_POST['FORMDate5'],$_POST['FORMDate3']);


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
    
    foreach($UpdateQueries as $Req){
        $SQL2->QUERY($Req);
    }
        
    $Montant = floatval(str_replace(',','.',$_POST['FORMMontant']));
    $Notes = $_POST['FORMNotes']." Paye:".$Paid;
    $Req2 = "INSERT INTO paiement(`Cote`,`Montant`,`Notes`,`Date`) VALUES('".$_POST['Cote']."',".$Montant.",'".addslashes($Notes)."',".$Time.")";
    $SQL->INSERT($Req2);
    $MainOutput->AddTexte('Paiement ajouté','Warning');
}else{
    
    $MainOutput->AddTexte('Les factures sélectionnées ne sont pas sur les mêmes années de facturation. Veuillez scinder le paiement afin d\'assurer la cohérence du dossier de facturation','Warning');
}



?>