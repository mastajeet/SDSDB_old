<?PHP
$SQL = new sqlclass;

if(isset($_GET['ADD']) && $_GET['ADD']==TRUE){
	if(isset($_GET['Cote'])){
		$MainOutput->AddForm('Ajouter un paiement');
		$MainOutput->inputhidden_env('Action','Paiement');
		$MainOutput->inputhidden_env('Cote',$_GET['Cote']);
		$Req = "SELECT IDFacture, Sequence FROM facture WHERE !Paye AND !Credit AND Cote='".$_GET['Cote']."' ORDER BY Sequence ASC";
		$SQL->SELECT($Req);
		$opt = array();
		while($Rep = $SQL->FetchArray())
			$opt[$Rep[0]] = $_GET['Cote']."-".$Rep[1];
		
                $MainOutput->InputText('Montant',$Rep['TXH'],6);
		$MainOutput->FlagList('ToPay',$opt,'','Factures');
		$MainOutput->InputTime('Date','Date',0,array('Date'=>TRUE,'Time'=>FALSE));
		$MainOutput->InputText('Notes',$Rep['Notes']);
		$MainOutput->formsubmit('Effectuer');
	}
}else{

if(!isset($_GET['Year']) or $_GET['Year']=="")
	$Year = intval(Date("Y"));
else
	$Year =$_GET['Year'];
	
	
$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('',3);
	$MainOutput->AddTexte('Détail des paiements');
	$MainOutput->br();
	$MainOutput->AddLink('index.php?Section=Paiement&ADD=TRUE&Cote='.$_GET['Cote'],'Ajouter un paiement');
	$MainOutput->br();
	$MainOutput->AddLink('index.php?Section=Display_Facturation&Cote='.$_GET['Cote'],'Retour au dossier de facturation');
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

	$Req = "SELECT `Sequence`, round(round(STotal*(1+TPS),2)*(1+TVQ),2) as Total FROM facture WHERE Cote='".$_GET['Cote']."' and !Credit and semaine>=".mktime(0,0,0,1,1,$Year)." and semaine<".mktime(0,0,0,1,1,$Year+1);
	$SQL->SELECT($Req);
		$IDFactureStr ="AND (0 ";
                $FactureTotal = array();
	while($Rep = $SQL->FetchArray()){
		$IDFactureStr .= "OR Notes LIKE '%~".$_GET['Cote']."-".$Rep[0]."~%'";
                $FactureTotal[$Rep['Sequence']]=$Rep['Total'];
	}
	$IDFactureStr .= ")";
	$Req = "SELECT Date, Montant, Notes FROM paiement WHERE Cote = '".$_GET['Cote']."' ".$IDFactureStr." ORDER BY Date DESC";
	$SQL->SELECT($Req);
	while($Rep = $SQL->FetchArray()){
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$Date = get_date($Rep[0]);
		$month = get_month_list('long');
		$MainOutput->addTexte($Date['d']." ".$month[intval($Date['m'])]." ".$Date['Y']);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte(number_format($Rep[1],2)." $");
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	
        $pp = explode('~',stristr($Rep[2],'Paye'));
        $PaiementShouldbe = 0;
            foreach($pp as $facture){
            
                
            if(stristr($facture,'-'))
         $PaiementShouldbe +=$FactureTotal[substr(stristr($facture,'-'),1)];            
        }
      
        if(abs($PaiementShouldbe-$Rep[1])>0.1){
         
            $Debalance = round($PaiementShouldbe-$Rep[1],2);
            $MainOutput->AddTexte("<span class=Warning>Débalance: ". $Debalance."</span>");
        }
	if(stristr($Rep[2],'balance')){
		$pp = stristr($Rep[2],'Paye');
		$PayePlus = strlen($pp);
		$Total = strlen($Rep[2]);
		$Balance = $Total-$PayePlus;
		$Engras = "<b>".substr($Rep[2],0,$Balance )."</b>";
		$Rep[2] = $Engras." ".$pp;
		
	}
	
		$MainOutput->AddTexte($Rep[2]);
	
	
	
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	}
	$MainOutput->CloseTable();
}
echo $MainOutput->Send(1);
?>