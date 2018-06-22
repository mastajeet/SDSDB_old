<?PHP

function get_balance_installation($IDInstallation){
	$SQL = new sqlclass;
	$Req = "SELECT Balance FROM installation WHERE IDInstallation=".$IDInstallation;
	$SQL->SELECT($SQL);
	$Rep = $SQL->FetchArray();
	return $Rep[0];
}

function get_balance_cote($Cote){
	$SQL = new sqlclass;
	$Req = "SELECT sum(Balance) FROM installation WHERE `Cote`='".$Cote;
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	return $Rep[0];	
}

function get_balance_client($IDClient){
	$SQL = new sqlclass;
	$Req = "SELECT Balance FROM Client WHERE IDClient=".$IDClient;
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	return $Rep[0];
}

function update_balance_client($IDClient){
	$SQL = new sqlclass;
	$Req = "SELECT sum(Balance) FROM installation WHERE `IDClient`=".$IDClient;
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	$Req = "UPDATE client SET `Balance` = ".$Rep[0]." WHERE IDClient=".$IDClient;
	$SQL->Query($Req);
	return $Rep[0];
}

function update_installation_balance($IDInstallation,$Total){
	$SQL = new sqlclass;
	$Req = "UPDATE installation SET `Balance` = `Balance`+".$Total." WHERE IDInstallation=".$IDInstallation;
	$SQL->Query($Req);
}

function get_last_facture($Cote){
	$SQL = new sqlclass;
	$Req = "SELECT Sequence FROM facture WHERE `Cote`='".$Cote."' AND Credit=0 ORDER BY Sequence DESC LIMIT 0,1";
	$SQL->SELECT($Req);
	if($SQL->NumRow()){
		$Rep = $SQL->FetchArray();
		return $Rep[0];
	}else{
		$Info = get_cote_summary($Cote);
		return $Info['Seq'];
	}
}

function get_last_credit($Cote){
	$SQL = new sqlclass;
	$Req = "SELECT Sequence FROM facture WHERE `Cote`='".$Cote."' AND Credit=1 ORDER BY Sequence DESC LIMIT 0,1";
	$SQL->SELECT($Req);
	if($SQL->NumRow()){
		$Rep = $SQL->FetchArray();
		return $Rep[0];
	}else{
		$Info = get_cote_summary($Cote);
		return $Info['Seqc'];
	}
}

function add_facture($Cote,$Semaine,$Credit=FALSE,$Notes="",$Seq="",$Materiel=FALSE,$Taxes=TRUE){
	if($Notes==""){
		$Notes = get_vars('NoteFacture');
	}

	if(!$Materiel)
		$Materiel=0;
	else
		$Materiel=1;

	$TVQ = 0;
	$TPS = 0;
    if($Taxes){
		$TVQ = get_vars('TVQ');
		$TPS = get_vars('TPS');
	}
	$SQL = new sqlclass;
	//Cote
	if($Credit)
		$Paye=1;
	else
		$Paye=0;
	if($Seq==""){
		if($Credit){
			$Seq = get_last_credit($Cote);
			$Credit=1;
        }else{
			$Seq = get_last_facture($Cote);
			$Credit=0;
        }
		$Seq++;
	}
	$Req = "INSERT INTO facture(`Sequence`,`Cote`,`TVQ`,`TPS`,`Semaine`,`EnDate`,`Notes`,`Credit`,`Paye`,`Materiel`) VALUES(".$Seq.",'".$Cote."','".$TVQ."','".$TPS."',".$Semaine.",".time().",'".addslashes($Notes)."',".$Credit.",".$Paye.",".$Materiel.")";
	$SQL->INSERT($Req);
	return get_last_id('facture');
}

function get_cote_list($IDClient){
	$SQL = new sqlclass;
	$Req = "SELECT DISTINCT Cote FROM installation WHERE `IDClient`=".$IDClient;
	$ret = array();
	while($Rep = $SQL->FetchArray()){
		$ret[] = $Rep[0];
	}
	return $ret;
}

function get_facturation($Cote,$Dossier=FALSE,$Year=NULL){

	if(is_null($Year))
		$Year = intval(date("Y"));
		

		
	$SQL = new sqlclass;
	if($Dossier){
		$Req = "SELECT IDFacture FROM facture WHERE !Paye AND Cote='".$Cote ."' ORDER BY IDFacture ASC LIMIT 0,1";
		$SQL->SELECT($Req);
		$Rep = $SQL->FetchArray();
			$Req = "SELECT `STotal`, `STotal`*round(`TPS`,3) as TPSp, `STotal`*round((1+`TPS`),3)*round(`TVQ`,3), `Sequence`, `IDFacture`, `Semaine`, `Credit`,`Paye`,`EnDate`,`IDFacture` FROM facture WHERE Cote='".$Cote."' AND IDFacture >= ".$Rep['IDFacture']." ORDER BY IDFacture DESC";
	}else{
		$Req = "SELECT `STotal`, `STotal`*round(`TPS`,3) as TPSp, `STotal`*round((1+`TPS`),3)*round(`TVQ`,3), `Sequence`, `IDFacture`, `Semaine`, `Credit`,`Paye`,`EnDate`,`IDFacture` FROM facture WHERE Cote='".$Cote."' and Semaine>=".mktime(0,0,0,1,1,$Year)." and Semaine<".mktime(0,0,0,1,1,$Year+1)." ORDER BY IDFacture DESC";
	}
	$SQL->SELECT($Req);
	$ret = array();
	while($Rep = $SQL->FetchArray()){
	$TPSp = round($Rep[1],2);
	$TVQp = round($Rep[2],2);
		$ret[$Rep[4]] = array('IDFacture'=>$Rep[9],'Sequence'=>$Rep[3],'Semaine'=>$Rep[5],'STotal'=>$Rep[0],'TPS'=>$TPSp,'TVQ'=>$TVQp, 'Total'=>$Rep[0]+$TPSp+$TVQp, 'Credit'=>$Rep[6],'Paye'=>$Rep[7],'Date'=>$Rep[8]);	
	}
	return $ret;
}

function get_cote_summary($Cote,$Year=NULL){
	if(is_null($Year))
		$Year = intval(date("Y"));
	$SQL = new sqlclass;
    $Req = "SELECT `Sequence`, `STotal`,`STotal`*round(`TPS`,3), `STotal`*round((1+`TPS`),3)*round(`TVQ`,3), Paye, Credit FROM facture WHERE Cote='".$Cote."' and semaine>=".mktime(0,0,0,1,1,$Year)." AND semaine<".mktime(0,0,0,1,1,$Year+1);
	$SQL->SELECT($Req);
		$total_sous_total = 0;
		$total_tps = 0;
		$total_tvq = 0;
		$Solde = 0;
		$SoldeImpaye = 0;
		$IDFactureStr ="AND (0 ";
	while($Rep = $SQL->FetchArray()){

        $isPaid = $Rep[4];
        $isCredit = $Rep['Credit'];

	    if(!$isCredit)
			$IDFactureStr .= "OR Notes LIKE '%~".$Cote."-".$Rep[0]."~%'";

        $current_sous_total = round($Rep[1], 2);
        $current_tps = round($Rep[2], 2);
        $current_tvq = round($Rep[3], 2);

        $total_sous_total += $current_sous_total;
        $total_tps += $current_tps;
        $total_tvq += $current_tvq;

        if(!$isPaid or $isCredit){
            $SoldeImpaye += $current_sous_total+ $current_tps + $current_tvq;
        }
    }

	$IDFactureStr .= ")";
	//$Req = "SELECT round(sum(`Balance`),2), sum(`Seq`), sum(`Seqc`) FROM installation WHERE Cote='".$Cote."' GROUP BY Cote";
	//$SQL->SELECT($Req);
	//$Rep3 = $SQL->FetchArray();
    $Req = "SELECT round(sum(`Montant`),2) FROM paiement WHERE Cote='".$Cote."' ".$IDFactureStr." GROUP BY Cote";
	$SQL->SELECT($Req);
	$Rep2 = $SQL->FetchArray();
	if($Rep2[0]=='')
		$Rep2[0]=0;
	$Solde = $total_sous_total+$total_tps+$total_tvq - $Rep2[0];
    $cote_summary = array('STotal'=>$total_sous_total,'TPS'=>$total_tps,'TVQ'=>$total_tvq,'Total'=>$total_sous_total+$total_tps+$total_tvq,'Paiement'=>$Rep2[0],'Solde'=>$Solde,'Seq'=>NULL,'Seqc'=>NULL,'SoldeImpaye'=>$SoldeImpaye);
	return($cote_summary);
}

function update_facture_balance($IDFacture){
	$SQL = new sqlclass;
	$Req = "SELECT Materiel FROM facture WHERE IDFacture=".$IDFacture;
	$SQL->SELECT($Req);
	$Rep = 	$SQL->FetchArray();
	
	$Req = "SELECT TXH, End-Start FROM factsheet WHERE IDFacture = ".$IDFacture;
	$SQL->SELECT($Req);
	$STot = 0;

	if($Rep['Materiel']){
		while($Rep = $SQL->FetchArray()){
			$STot = $STot+ $Rep[0]*$Rep[1];
		}
	}else{
		while($Rep = $SQL->FetchArray()){
			$STot = $STot+ $Rep[0]*$Rep[1]/3600;
		}
	}

	$Req = "UPDATE facture SET STotal = ".$STot." WHERE IDFacture = ".$IDFacture;
	$SQL->Query($Req);
}


function get_facture_info($IDFacture){
	$SQL = new sqlclass;
	$Req = "SELECT * FROM facture WHERE IDFacture = ".$IDFacture;
	$SQL->SELECT($Req);
	return $SQL->FetchArray();
}
function get_paiement_info($IDPaiement){
	$SQL = new sqlclass;
	$Req = "SELECT * FROM paiement WHERE IDPaiement = ".$IDPaiement;
	$SQL->SELECT($Req);
	return $SQL->FetchArray();
}

?>