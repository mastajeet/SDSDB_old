<?php
if(!isset($_GET['Cote'])){
	$MainOutput->AddTexte('Aucune cote n\'à été sélectionnée');	
}else{
	$YearStamp = mktime(0,0,0,1,1,intval(date("Y")));

//Ramasser le solde annuel
	$Req = "SELECT `Sequence`, `STotal`,`STotal`*round(`TPS`,3), `STotal`*round((1+`TPS`),3)*round(`TVQ`,3), Paye, Credit, IDFacture FROM facture WHERE Cote='".$Cote."' and semaine>=".$YearStamp." Order By Semaine DESC";
	$SQL->SELECT($Req);
	$LikeStr = "";
	
	$STot = 0;
	$TPSp = 0;
	$TVQp = 0;
	$Solde = 0;
	$SoldeImpaye = 0;
	$LikeStr ="AND (0 ";
	$LastImpayee =0;
	$CreditCumulArray = array();
	$CreditCumul=0;
	while($Rep = $SQL->FetchArray()){
		if($Rep['Credit']==0)
			$LikeStr .= "OR Notes LIKE '%~".$Cote."-".$Rep[0]."~%'";
		if($Rep['Paye']==0)
			$LastImpayee = $Rep['IDFacture'];
		$STot = $STot+round($Rep[1],2);
		$TPSp = $TPSp+round($Rep[2],2);
		$TVQp = $TVQp+round($Rep[3],2);
		$CreditCumul = $CreditCumul + (round($Rep[3],2)+round($Rep[2],2)+round($Rep[1],2))*($Rep['Credit']);
		$CreditCumulArray[$Rep['IDFacture']] = $CreditCumul;
		$SoldeImpaye = $SoldeImpaye+(round($Rep[3],2)+round($Rep[2],2)+round($Rep[1],2))*(1-$Rep[4]);
	}
	$LikeStr .= ")";
//Ramasser le dernier paiement fait dans la période en cours



//	$SoldeImpaye = $SoldeImpaye + $CreditCumulArray[$LastImpayee];
// Vérifier le comportement des crédits


	$Req = "SELECT * FROM paiement WHERE Cote = '".$_GET['Cote']."' ".$LikeStr." ORDER BY IDPaiement DESC Limit 0,1";
	$SQL->SELECT($Req);	
	$ListToInclude = "";	
	if($SQL->NumRow()<>0){
		$INFOPMT = $SQL->FetchArraY();
		$ListPayee = explode("~",$INFOPMT['Notes']);

		foreach($ListPayee as $v){
			if($STRPOS = strpos($v,"-")){
				$ListToInclude .= substr($v,$STRPOS+1).",";
			}
		}
	
	}else
		$INFOPMT = array('IDPaiement'=>0,'Montant'=>0);

	$ListToInclude .= "0";
//Ramasser les factures après 
if($LastImpayee<>0){
	$Req = "SELECT `Sequence`, `STotal`,`STotal`*round(`TPS`,3) as TPS, `STotal`*round((1+`TPS`),3)*round(`TVQ`,3) as TVQ, `STotal`*round((1+`TPS`),3)*round((1+`TVQ`),3) as Total, Paye, Credit, EnDate FROM facture WHERE Cote='".$Cote."' and (EnDate>=(SELECT EnDate FROM facture WHERE IDFacture=".$LastImpayee.") or (Sequence in (".$ListToInclude.") and !Credit)) Order By Semaine DESC, Sequence DESC";

	
$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('60%',5);

	$MainOutput->AddPic('logo.jpg');
	$MainOutput->br();

	$MainOutput->AddTexte('Installation(s): ','Titre');
	$MainOutput->AddTexte(get_associated_cote($_GET['Cote']));
	$MainOutput->br();
	$MainOutput->AddTexte('Cote: ','Titre');
	$MainOutput->AddTexte($_GET['Cote']);
	$MainOutput->br();	



$MainOutput->CloseCol();
$SQL3 = new SQLclass;
$MainOutput->OpenCol('',3);
$Req2 = "SELECT client.`Nom`, client.`Adresse`, client.`Facturation`, client.`Fax`, client.`Email`, responsable.`Nom`, responsable.Prenom, client.Tel FROM installation join client join responsable on installation.IDClient = client.IDClient AND client.RespF = responsable.IDResponsable WHERE installation.Cote = '".$_GET['Cote']."'";
$SQL->SELECT($Req2);
$Rep = $SQL->FetchArray();
$MainOutput->AddTexte('Facturé à: ','Titre');
		$MainOutput->AddTexte($Rep[0]);
		$MainOutput->br();
		$MainOutput->AddTexte('A/S: ','Titre');
		$MainOutput->AddTexte($Rep[6]." ".$Rep[5]." ");
		$MainOutput->br();
		$MainOutput->AddTexte('Tel.: ','Titre');
		$MainOutput->AddTexte("(".substr($Rep[7],0,3).") ".substr($Rep[7],3,3)."-".substr($Rep[7],6,4));
					if(strlen(substr($Rep[7],10,4))>1)
						$MainOutput->AddTexte(" #".substr($Rep[7],10,4));
		$MainOutput->br();
		$MainOutput->AddTexte($Rep[1]);
		$MainOutput->br();
			if($Rep[2]=="E"){
				$MainOutput->AddTexte('Email: ','Titre');
				$MainOutput->AddTexte($Rep[4]);
			}
			if($Rep[2]=="F")
				$MainOutput->AddTexte("<b>Fax.</b>: (".substr($Rep[3],0,3).") ".substr($Rep[3],3,3)."-".substr($Rep[3],6,4));
	
$MainOutput->CloseCol();


$MainOutput->CloseRow();


if($INFOPMT['IDPaiement']<>0){
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',8);
$MainOutput->br();
	$MainOutput->AddTexte('Solde antérieur','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',8);
	$MainOutput->AddTexte(number_format($SoldeImpaye+$INFOPMT['Montant'],2)." $");
$MainOutput->CloseCol();
$MainOutput->CloseRow();



$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',8);
$MainOutput->br();
	$MainOutput->AddTexte('Dernier paiement','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();



$MainOutput->OpenRow();

$MainOutput->OpenCol('');
	$MainOutput->AddTexte(number_format($INFOPMT['Montant'],2)." $");
$MainOutput->CloseCol();


$MainOutput->OpenCol('');
	$MainOutput->AddTexte(datetostr($INFOPMT['Date']));
$MainOutput->CloseCol();

$MainOutput->OpenCol('',6);
	$MainOutput->AddTexte($INFOPMT['Notes']);
$MainOutput->CloseCol();





$MainOutput->CloseRow();

}


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',8);
$MainOutput->br();
	$MainOutput->AddTexte('Solde actuel','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',8);
	$MainOutput->AddTexte(number_format($SoldeImpaye,2)." $",'Warning');
$MainOutput->CloseCol();
$MainOutput->CloseRow();




$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',8);
$MainOutput->br();

	$MainOutput->AddTexte('Détail','Titre');

$MainOutput->CloseCol();
$MainOutput->CloseRow();




$MainOutput->OpenRow();
	$MainOutput->OpenCol(20);
		$MainOutput->AddTexte(' ');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol(50);
		$MainOutput->AddTexte('Date','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol(25);
		$MainOutput->AddTexte('Détail','Titre');
	$MainOutput->CloseCol(100);
		$MainOutput->OpenCol(100);
		$MainOutput->AddTexte('À Recevoir','Titre');
	$MainOutput->CloseCol();
        $MainOutput->OpenCol(100);
		$MainOutput->AddTexte('Reçu','Titre');
	$MainOutput->CloseCol();
		$MainOutput->OpenCol(100);
		$MainOutput->AddTexte('Reçu','Titre');
	$MainOutput->CloseCol();
$MainOutput->CloseRow();

$SQL->SELECT($Req);

while($Rep = $SQL->FetchArraY()){
	$MainOutput->OpenRow();

		$MainOutput->OpenCol();
		//NOTHING
		$MainOutput->CloseCol();

		$MainOutput->OpenCol();
		$Date = get_date($Rep['EnDate']);
			$MainOutput->AddTexte($Date['d']."-".$Date['m']."-".$Date['Y']);
		$MainOutput->CloseCol();
		$MainOutput->OpenCol();
		$Class = 'Warning';
		if($Rep['Paye'] || $Rep['Credit'])
			$Class = 'Titre';
		$Credit='';
			if($Rep['Credit'])
				$Credit='c';
			$MainOutput->AddTexte($Credit.$_GET['Cote']."-".$Rep['Sequence'],$Class);
		$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
			$MainOutput->AddTexte(number_format($Rep['Total'],2)." $");
		$MainOutput->CloseCol();
			$MainOutput->OpenCol();
                        
                        
                        $MainOutput->OpenCol();
			$MainOutput->AddTexte(number_format($Rep['Total'],2)." $");
		$MainOutput->CloseCol();
			$MainOutput->OpenCol();
			
			if($Rep['Credit'])
				$MainOutput->AddTexte('N/A','Titre'); //METTRE LA DATE OU ENCORE LE NUMÉRO DE DÉPOT OU LE NUMÉRO DE CHEQUE...
			elseif($Rep['Paye'] && !$Rep['Credit']){
				$Req = "SELECT Date FROM paiement WHERE Notes LIKE '%~".$_GET['Cote']."-".$Rep['Sequence']."~%'";
				$SQL3->SELECT($Req);
				$Rep3 = $SQL3->FetchArray();
				$DatePaid = get_date($Rep3[0]);
				$month = get_month_list('long');
				$MainOutput->AddTexte($DatePaid['d']." ".$month[intval($DatePaid['m'])]." ".$DatePaid['Y'],'Titre'); //METTRE LA DATE OU ENCORE LE NUMÉRO DE DÉPOT OU LE NUMÉRO DE CHEQUE...
			}
			
		$MainOutput->CloseCol();
	$MainOutput->CloseRow();

}
}
$MainOutput->CloseTable();
}


echo $MainOutput->Send(1);
?>
