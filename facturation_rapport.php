<?PHP
$Req = "SELECT Semaine, round(sum(STotal*(1+TVQ)*(1+TPS)),2) FROM facture Group By Semaine ORDER BY Semaine DESC LIMIT 0,10";
$SQL = new sqlclass();

$SQL->SELECT($Req);
$MainOutput->OpenTable('500');
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('<div align=center>Facturation par semaine - 10 semaines</div>','Titre');
$MainOutput->Closecol();
$MainOutput->CloseRow();


while($Rep = $SQL->FetchArray()){
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
	$End = get_end_dates(0,$Rep[0]);
		$MainOutput->Addtexte($End['Start'].' au '.$End['End'],'Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte($Rep[1].' $');
	$MainOutput->Closecol();
	$MainOutput->CloseRow();
}
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->AddTexte('&nbsp;');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->AddTexte('Recevables');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$Req = "SELECT IDClient, Nom, Cote FROM client ORDER BY Nom ASC";
$SQL->SELECT($Req);
$YearStamp = mktime(0,0,0,1,1,intval(date("Y")));


$SQL2 = new SQLclass();
$SQL3 = new sqlclass();
$Total = 0;

$c="four";
while($Rep = $SQL->FetchArray()){
		
	$Solde = 0;        
    $YearStamp = mktime(0,0,0,1,1,intval(date("Y")));
 
	$Req2 = "SELECT DISTINCT Cote FROM installation WHERE IDClient = ".$Rep[0];
		$SQL2->SELECT($Req2);
	$APayer = 0;
	$Paye = 0;
	while($Rep2 = $SQL2->FetchArray()){
		
		
		
		$Req = "SELECT `Sequence` FROM facture WHERE Cote='".$Rep2['Cote']."' and !Credit and semaine>=".$YearStamp;
		$SQL3->SELECT($Req);
			$IDFactureStr ="AND (0 ";
		while($Rep3 = $SQL3->FetchArray()){
			$IDFactureStr .= "OR Notes LIKE '%~".$Rep2['Cote']."-".$Rep3[0]."~%'";
		}
		$IDFactureStr .= ")";
		
	$Req = "SELECT Date, Montant, Notes FROM paiement WHERE Cote = '".$Rep['Cote']."' ".$IDFactureStr." ORDER BY Date DESC";
	$SQL3->SELECT($Req);
         
        
//Ramasser le solde annuel
	$Req = "SELECT round(round(Stotal*(1+TVQ),2)*(1+TPS),2) as Total, Sequence as Detail,'' as Notes, 'F' as FactType, Credit, EnDate as ReqDate from facture where Cote ='".$Rep2['Cote']."' and Semaine>=".$YearStamp." UNION Select round(Montant,2) as Total,0, Notes, 'P',0, `Date` as ReqDate FROM paiement WHERE Cote = '".$Rep2['Cote']."' ".$IDFactureStr." and `Date`>=".$YearStamp." Order by ReqDate ASC";
	
	$SQL3->SELECT($Req);
	
		
   
        while($Rep3 = $SQL3->FetchArray()){
            
            if($Rep3['FactType']=="F"){
                $ARec = $Rep3['Total'];
                $Credit = "";
                $Rec = 0;
         
            }elseif($Rep3['FactType']=="P"){
                $ARec = 0;
                $Rec = $Rep3['Total'];
		   }
            $Solde += $ARec-$Rec;
            
        }
		
	}
	$Balance = $Solde;
	$Balance = floor($Balance*100)/100;
	if(abs($Balance)-0.05>0){


if($c=="four")
	$c="three";
else
	$c="four";

		$MainOutput->OpenRow('',$c);
		$MainOutput->OpenCol('75%',1,'top',$c);
			$MainOutput->addlink('index.php?Section=Client_DossierFacturation&Cote='.$Rep['Cote'].'&ToPrint=TRUE&NB=15',$Rep[1],"_BLANK");
		$MainOutput->CloseCol();
		$MainOutput->OpenCol('25%',1,'top',$c);
			$MainOutput->AddTexte(number_format($Balance,2)." $");
		$MainOutput->CloseCol();
	$Total = $Total + $Balance;
	}

	
}
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->AddTexte('&nbsp;');
$MainOutput->Closecol();
$MainOutput->CloseRow();


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->AddTexte('Total: '.round($Total,2)." $",'Titre');
$MainOutput->Closecol();
$MainOutput->CloseRow();

$MainOutput->CloseTable();
echo $MainOutput->Send(1);
?>