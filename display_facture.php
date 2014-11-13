<?PHP

if(isset($_GET['IDFacture'])){
	$SQL = new sqlclass;
if(!isset($Modifie))
	$Modifie=FALSE;	
	
	$Info = get_facture_info($_GET['IDFacture']);
	$Req = "SELECT * FROM factsheet WHERE IDFacture = ".$_GET['IDFacture']." ORDER BY Jour ASC, Start ASC";
	$SQL->SELECT($Req);
	$Head = new HTML;
	$Req2 = "SELECT client.`Nom`, client.`Adresse`, client.`Facturation`, client.`Fax`, client.`Email`, responsable.`Nom`, responsable.Prenom, installation.Factname, installation.ASFact, installation.AdresseFact, client.FrequenceFacturation FROM facture join installation join client join responsable on facture.Cote = installation.Cote AND installation.IDClient = client.IDClient AND client.RespF = responsable.IDResponsable WHERE IDFacture = ".$_GET['IDFacture'];
	
	$MainOutput->OpenTable(660);
	



if(!$Info['Materiel']){
	$MainOutput->OpenRow();
	$MainOutput->OpenCol(30);
		$MainOutput->AddTexte('Date','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol(20);
		$MainOutput->AddTexte('<div align=center>Début</div>','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol(20);
		$MainOutput->AddTexte('Fin','Titre');
	$MainOutput->CloseCol();
}
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('Description','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol(30);
		$MainOutput->AddTexte('Qté','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol(50);
		$MainOutput->AddTexte('Taux','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol(85);
		$MainOutput->AddTexte('Total','Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$NBH = 0;
	$Cash = 0;
	
	while($Rep = $SQL->FetchArray()){
	

if(!$Info['Materiel']){
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
if($Modifie)
 		$MainOutput->addlink('index.php?Section=Factsheet&IDFactsheet='.$Rep['IDFactsheet'],'<img border=0 src=b_edit.png>');
	$CurrentJour=1;
    $CurrentDate = 	$Info['Semaine'];
    while($CurrentJour<=$Rep['Jour']){
        $CurrentDate+=get_day_length($CurrentDate);
    }
true;
    $MainOutput->AddTexte(date('j-m-Y',$CurrentDate));

	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('<div align=center>'.round($Rep['Start']/3600,2).'</div>');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte(round($Rep['End']/3600,2));
	$MainOutput->CloseCol();
}
	$MainOutput->OpenCol();
		$MainOutput->AddTexte($Rep['Notes']);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();

if($Info['Materiel'])
	$DIFF = $Rep['End'];
else
	$DIFF = round(($Rep['End']-$Rep['Start'])/3600,2);

		$MainOutput->AddTexte($DIFF);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte(number_format(round($Rep['TXH'],2),2)."&nbsp;$");
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte(number_format(round($Rep['TXH']*$DIFF,2),2)."&nbsp;$");
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$Cash = $Cash+$DIFF*$Rep['TXH'];
	$NBH = $NBH+$DIFF;
	
	}
	
$Cash = round($Cash,2);

$Bottom = file('basfacture.txt');

$MainOutput->OpenRow();
	
	

if(!$Info['Materiel'])
	$MainOutput->OpenCol('',7);
else
	$MainOutput->OpenCol('',4);
		$MainOutput->AddTexte("----------------------------------------------------------------------------------------------------------------------------------",'Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();


$MainOutput->OpenRow();
	
if(!$Info['Materiel'])
	$MainOutput->OpenCol('',4);
else
	$MainOutput->OpenCol('',1);
	
		$MainOutput->AddTexte($Bottom[0],'Small');
	$MainOutput->CloseCol();
	
	$MainOutput->OpenCol('',2);
		$MainOutput->AddTexte('<div align=right>Sous-Total: </div>','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte(number_format($Cash,2)."&nbsp;$",'Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();



	$MainOutput->OpenRow();

	
if(!$Info['Materiel'])
	$MainOutput->OpenCol('',4);
else
	$MainOutput->OpenCol('',1);
	
	$MainOutput->AddTexte($Bottom[1],'Small');
	$MainOutput->CloseCol();
	
	$TPS = $Cash * $Info['TPS'];
	$TVQ = ($Cash+$TPS) * $Info['TVQ'];
	$TPS = round($TPS,2);
	$TVQ = round($TVQ,2);
	$TTPS = 100*$Info['TPS'];
	//$TTVQ = 100*$Info['TVQ']; //Modification due au changement du calcul de la TVQ. on affiche la variable TVQShown mais utilise TVQ pour le calcul (aucun changement dans le code) 
	$TTVQ = get_vars('TVQShown');
	$MainOutput->OpenCol('',2);
		$MainOutput->AddTexte("<div align=right>TPS - ".$TTPS."%: </div>",'Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte(number_format($TPS,2)."&nbsp;$",'Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	
		$MainOutput->OpenRow();
if(!$Info['Materiel'])
	$MainOutput->OpenCol('',4);
else
	$MainOutput->OpenCol('',1);
	
		$MainOutput->AddTexte($Bottom[2],'Small');
	$MainOutput->CloseCol();
	
	$MainOutput->OpenCol('',2);

		$MainOutput->AddTexte('<div align=right>TVQ - '.$TTVQ.': </div>','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte(number_format($TVQ,2)."&nbsp;$",'Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	


$MainOutput->OpenRow();
	
if(!$Info['Materiel'])
	$MainOutput->OpenCol('',4);
else
	$MainOutput->OpenCol('',1);

		$MainOutput->AddTexte($Bottom[3],'Small');
	$MainOutput->CloseCol();

	$MainOutput->OpenCol('',3);
		$MainOutput->AddTexte("--------------------------",'Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();



	$MainOutput->OpenRow();

if(!$Info['Materiel'])
	$MainOutput->OpenCol('',4);
else
	$MainOutput->OpenCol('',1);

		$MainOutput->AddTexte($Bottom[4],'Small');
	$MainOutput->CloseCol();

	$Cash = $Cash + $TVQ + $TPS;
	$MainOutput->OpenCol('',2);
		$MainOutput->AddTexte('<div align=right>Total: </div>','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte(number_format($Cash,2)."&nbsp;$",'Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
				$MainOutput->OpenRow();
	
	$MainOutput->OpenCol('',4);
		$MainOutput->AddTexte(' ','Small');
	$MainOutput->CloseCol();

	$MainOutput->OpenCol('',2);
		$MainOutput->AddTexte(' ');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte(' ');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('',7);
$MainOutput->AddTexte('<div align=center><span class="Titre">'.$Bottom[5].' '.$Bottom[6].' </span>'.$Bottom[7].' '.$Bottom[8].' '.$Bottom[9].' </div>','Small');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->CloseTable();

	
	$TEMP = $MainOutput->send(1);
	
	
	$SQL->SELECT($Req2);
	$Rep = $SQL->FetchArray();
	
	$MainOutput->OpenTable(525);
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('60%');
		$MainOutput->AddPic('logo.jpg');
	
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		
	$InvType ="";
	
			
		if($Info['Credit'])
			$InvType = "NOTE DE CRÉDIT";
		else
			$InvType = "FACTURE";
		
		if($Info['Materiel'])
			$InvType .= " MATÉRIEL";	
		
		if($Info['Materiel'] && $Info['Credit'])
			$InvType = "CRÉDIT MATÉRIEL";	
		
		
		$MainOutput->AddTexte('<div align=right>'.$InvType.'</div>','BigHead');
		
		if($Modifie){
			$MainOutput->AddOutput('<div align=Right>',0,0);

			$MainOutput->AddLink('index.php?Section=Factsheet&IDFacture='.$_GET['IDFacture'],'<img src=b_ins.png border=0>');
			$MainOutput->AddTexte('&nbsp;');
			$MainOutput->AddLink('index.php?Section=Display_Facture&ToPrint=TRUE&IDFacture='.$_GET['IDFacture'],'<img src=b_print.png border=0>','_BLANK');
			$MainOutput->AddLink('index.php?Section=Display_Facturation&Cote='.$Info['Cote'],'<img src=b_fact.png border=0>');
			$MainOutput->AddTexte('&nbsp;');
			$MainOutput->AddLink('index.php?Action=Delete_Facture&IDFacture='.$_GET['IDFacture'],'<img src=b_del.png border=0>');
			$MainOutput->AddOutput('</div>',0,0);
		}
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$CREDIT = "";
		$MTL = "";
		if($Info['Credit'])
			$CREDIT = "c";
		if($_COOKIE['CIESDS']=="MTL")
			$MTL = "M-";
		$MainOutput->AddTexte($MTL.$CREDIT.$Info['Cote']."-".$Info['Sequence'],'Titre');
		$MainOutput->br();
		$MainOutput->AddTexte("Heures Chargées: ",'Titre');
		$MainOutput->AddTexte($NBH);
		$MainOutput->br();
		$MainOutput->AddTexte("Total: ",'Titre');
		$MainOutput->AddTexte(number_format($Cash,2)."&nbsp;$");
		$MainOutput->br();
		$MainOutput->AddTexte("Facturé: ",'Titre');
$month = get_month_list('long');
$date = get_date($Info['EnDate']);
		$MainOutput->AddTexte($date['d']."-".$month[intval($date['m'])]."-".$date['Y']);
		$MainOutput->br();
		$MainOutput->AddTexte("Pour la période: ",'Titre');

$ENDS = get_end_dates(0,$Info['Semaine']);

if($Rep['FrequenceFacturation']=='H'){
		$MainOutput->AddTexte($ENDS['Start']." au ".$ENDS['End']);

}
elseif($Rep['FrequenceFacturation']=='M'){
	$PremiereSemaineFullNewMonth = get_next_sunday(0,$Info['Semaine']);
	$MoisFacture = date('F',$PremiereSemaineFullNewMonth);
	$MainOutput->AddTexte($MoisFacture);

}
		
		
		
		
		
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('Facturé: ','Titre');
		if($Rep[7]<>"")
			$MainOutput->AddTexte($Rep[7]);
		else
			$MainOutput->AddTexte($Rep[0]);
		$MainOutput->br();
	
		$MainOutput->AddTexte('A/S: ','Titre');
		if($Rep[8]<>"")
			$MainOutput->AddTexte($Rep[8]);
		else
			$MainOutput->AddTexte($Rep[6]." ".$Rep[5]);	
		$MainOutput->br();
		if($Rep[9]<>"")
			$MainOutput->AddTexte($Rep[9]);		
		else
			$MainOutput->AddTexte($Rep[1]);
		$MainOutput->br();
			if($Rep[2]=="E"){
				$MainOutput->AddTexte('Email: ','Titre');
				$MainOutput->AddTexte($Rep[4]);
				}
			if($Rep[2]=="F"){
				$MainOutput->AddTexte("<b>Fax</b>.: (".substr($Rep[3],0,3).") ".substr($Rep[3],3,3)."-".substr($Rep[3],6,4));
					if(strlen(substr($Rep[3],10,4))>1)
						$MainOutput->AddTexte(" #".substr($Rep[3],10,4));
				}
		if($Info['BonAchat']<>""){
			$MainOutput->br();
	$MainOutput->AddTexte('Bon d\'achat: ','Titre');
			$MainOutput->AddTexte($Info['BonAchat']);
		}

	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('',2);
	$MainOutput->AddTexte('-----&nbsp;Détail&nbsp;---------------------------------------------------------------------------------------------------------------------','Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('',2);
		$MainOutput->AddOutput($TEMP,0,0);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->CloseTable();
	echo $MainOutput->send(1);
}