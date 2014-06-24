<?PHP
function mark_paid($IDFacture,$IDPaiement){
	$SQL = new sqlclass();
	$SQL->UPDATE("UPDATE facture SET Paye=1 WHERE IDFacture=".$IDFacture);
	$Req = "SELECT * FROM paiement WHERE IDPaiement = ".$IDPaiement;
	$Info = get_facture_info($IDFacture);
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	$Req2 = "SELECT Notes FROM paiement WHERE IDPaiement = ".$IDPaiement;
	$SQL->SELECT($Req);
	$Rep2 = $SQL->FetchArray();
	$Req3 = "UPDATE paiement SET Notes = '".$Rep2['Notes'].$Info['Cote']."-".$Info['Sequence']."~' WHERE IDPaiement = ".$IDPaiement;
	$SQL->UPDATE($Req3);
	
}


function mark_unpaid($IDFacture){
	$SQL = new sqlclass();
	$SQL->UPDATE("UPDATE facture SET Paye=0 WHERE IDFacture=".$IDFacture);
	$Info = get_facture_info($IDFacture);
	$Req3  = "SELECT * FROM paiement WHERE Notes LIKE '%".$Info['Cote']."-".$Info['Sequence']."%'";
	$SQL->SELECT($Req3);	
	$Rep3 = $SQL->FetchArray();
	$Rep3['Notes'] = str_replace($Info['Cote']."-".$Info['Sequence']."~",'',$Rep3['Notes']);
	$Req2 = "UPDATE paiement SET Notes = '".$Rep3['Notes']."' WHERE IDPaiement = ".$Rep3['IDPaiement'];
	$SQL->UPDATE($Req2);
}

function modifie_paiement($IDPaiement,$Montant,$TimeStamp,$Notes){
	$SQL = new sqlclass();
	$Req = "UPDATE paiement Set Notes = '".$Notes."', Montant='".$Montant."', Date='".$TimeStamp."' WHERE IDPaiement = ".$IDPaiement;
	$SQL->UPDATE($Req);	
}

function batch_update($SDate,$EDate,$IDInstallation,$UpdateStr,$WhereStr){
	$SQL = new sqlclass();
	$Req = "UPDATE shift SET ".$UpdateStr." WHERE IDInstallation=".$IDInstallation." AND Semaine+Jour*(24*3600)+Start>=".$SDate." AND Semaine+Jour*(24*3600)+Start<=".$EDate." ".$WhereStr;
	$SQL->UPDATE($Req);	
}

function modifie_facture_coteseq($ini,$fin){
	$SQL = new sqlclass();
	$Init = explode('-',$ini);
	if(count($Init)==2){
		$Req = "SELECT IDFacture FROM facture WHERE Cote='".$Init[0]."' AND Sequence=".$Init[1];
		$SQL->SELECT($Req);
		if($SQL->NumRow()==0)
			return "Facture non existante.";
		$Fint = explode('-',$fin);
		if(count($Fint)==1){
			$Fint[1]=$Fint[0];
			$Fint[0]=$Init[0];
		}
		$Fint[0] = strtoupper($Fint[0]);
		$Init[0] = strtoupper($Init[0]);
		$Req = "SELECT Nom from installation WHERE Cote='".$Fint[0]."'";
		$SQL->SELECT($Req);
		if($SQL->NumRow()==0)
			return "Cote ciblée non existante.";
		$Nom =  $SQL->FetchArray();
		$Req = "SELECT IDFacture FROM facture WHERE Cote='".$Fint[0]."' AND Sequence=".$Fint[1];
		$SQL->SELECT($Req);
		if($SQL->NumRow()<>0)
			return "Vous ne pouvez pas écraser une facturé qui existe déjà";
		$Req = "UPDATE facture SET Cote='".$Fint[0]."', Sequence='".$Fint[1]."' WHERE Cote='".$Init[0]."' AND Sequence=".$Init[1];
		$SQL->Update($Req);
			return $Init[0]."-".$Init[1]." est devenue ".$Fint[0]."-".$Fint[1]." et sera accèssible sous le dossier de facturation de <a href=index.php?Cote=".$Fint[0]."><b>".$Nom[0]."</b></a>";
	}ELSE{
		return "Veuillez entrer les information sous la forme 'Cote'-'Sequence'.";
	}
}
?>