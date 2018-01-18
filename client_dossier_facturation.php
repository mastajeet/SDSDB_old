<?php
const NO_SELECTED_COTE = 'Aucune cote n\'a été sélectionnée';
const BILLED_TO = 'Facturé à: ';
const BALANCE_TO_RECOVER = "<b>Solde du compte à recevoir: </b>";
const EFFECTIVE_DATE = "<b>En date du: </b>";
const TO_RECOVER = "<b>à recevoir</b>";
const DETAILS = "<b>Détail</b>";
const RECIEVED = "<b>Reçu</b>";
const BALANCE = "<b>Solde</b>";
const DATE = "<b>Date</b>";
const ANTERIOR_BALANCE = "<b>Solde Antérieur</b>";


if(!isset($_GET['Cote'])){
	$MainOutput->AddTexte(NO_SELECTED_COTE);
}else{
    
    if(!isset($_GET['NB']))
        $nbMax = 15;
    else
        $nbMax = $_GET['NB'];

    
	$YearStamp = mktime(0,0,0,1,1,intval(date("Y")));

        
        
        $Req = "SELECT `Sequence` FROM facture WHERE Cote='".$_GET['Cote']."' and !Credit and semaine>=".$YearStamp;
	$SQL->SELECT($Req);
		$IDFactureStr ="AND (0 ";
	while($Rep = $SQL->FetchArray()){
		$IDFactureStr .= "OR Notes LIKE '%~".$_GET['Cote']."-".$Rep[0]."~%'";
	}
	$IDFactureStr .= ")";
	$Req = "SELECT Date, Montant, Notes FROM paiement WHERE Cote = '".$_GET['Cote']."' ".$IDFactureStr." ORDER BY Date DESC";
	$SQL->SELECT($Req);
        
        
        
        
        
        
//Ramasser le solde annuel
	$Req = "SELECT round(round(Stotal*(1+TVQ),2)*(1+TPS),2) as Total, Sequence as Detail,'' as Notes, 'F' as FactType, Credit, EnDate as ReqDate from facture where Cote ='".$_GET['Cote']."' and Semaine>=".$YearStamp." UNION Select round(Montant,2) as Total,0, Notes, 'P',0, `Date` as ReqDate FROM paiement WHERE Cote = '".$_GET['Cote']."' ".$IDFactureStr." and `Date`>=".$YearStamp." Order by ReqDate ASC";
	$SQL->SELECT($Req);
        $NBElement = $SQL->NumRow();
        $FactArray = array();
	$Solde = 0;
        $nb=0;
        
        while($Rep = $SQL->FetchArray()){
            
            if($Rep['FactType']=="F"){
                $ARec = $Rep['Total'];
                $Credit = "";
                if($Rep['Credit']){
                    //$ARec = $ARec*-1;
                    $Credit = "c";
                }
                $Rec = "";
                $Detail =  $Credit.$_GET['Cote']."-".$Rep['Detail'];
            }elseif($Rep['FactType']=="P"){
                $ARec = "";
                $Rec = $Rep['Total'];
                $Detail = $Rep['Notes'];
            }                    
            
            
            $Solde += $ARec-$Rec;
            
            if($NBElement-$nb<=$nbMax){
                $FactArray[] = array('Date'=>$Rep['ReqDate'],'Detail'=>$Detail,'ARec'=>$ARec,'Rec'=>$Rec,'Solde'=>$Solde);
   
            }else{
                $SoldeAnterieur = $Solde;
            }
            $nb++;
        }
	
$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('60%');

	$MainOutput->AddPic('logo.jpg');
	$MainOutput->br();

	$MainOutput->AddTexte('Installation(s): ','Titre');
	$MainOutput->AddTexte(get_installation_by_cote_in_string($_GET['Cote']));
	$MainOutput->br();
	$MainOutput->AddTexte('Cote: ','Titre');
	$MainOutput->AddTexte($_GET['Cote']);
	$MainOutput->br();	



$MainOutput->CloseCol();
$SQL3 = new SQLclass;
$MainOutput->OpenCol('40%');
$Req2 = "SELECT client.`Nom`, client.`Adresse`, client.`Facturation`, client.`Fax`, client.`Email`, responsable.`Nom`, responsable.Prenom, client.Tel FROM installation join client join responsable on installation.IDClient = client.IDClient AND client.RespF = responsable.IDResponsable WHERE installation.Cote = '".$_GET['Cote']."'";
$SQL->SELECT($Req2);
$Rep = $SQL->FetchArray();
$MainOutput->AddTexte(BILLED_TO,'Titre');
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
$MainOutput->CloseTable();

$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%');
    $MainOutput->AddTexte(EFFECTIVE_DATE .datetostr(time()));
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%');
    $MainOutput->AddTexte(BALANCE_TO_RECOVER .number_format($Solde,2)." $");
$MainOutput->CloseCol();
$MainOutput->CloseRow();    


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%');
    $MainOutput->AddTexte("");
$MainOutput->CloseCol();
$MainOutput->CloseRow();    
$MainOutput->CloseTable();



$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('20%');
    $MainOutput->AddTexte(DATE);
$MainOutput->CloseCol();
$MainOutput->OpenCol('35%');
    $MainOutput->AddTexte(DETAILS);
$MainOutput->CloseCol();
$MainOutput->OpenCol('10%');
    $MainOutput->AddTexte(TO_RECOVER);
$MainOutput->CloseCol();

$MainOutput->OpenCol('10%');
    $MainOutput->AddTexte(RECIEVED);
$MainOutput->CloseCol();

$MainOutput->OpenCol('10%');
    $MainOutput->AddTexte(BALANCE);
$MainOutput->CloseCol();
$MainOutput->CloseRow();

if($NBElement>$nbMax){
    
        
    $MainOutput->OpenRow();
$MainOutput->OpenCol('',5);
    $MainOutput->AddTexte("<br>");
$MainOutput->CloseCol();


$MainOutput->CloseRow();
    
    $MainOutput->OpenRow();
$MainOutput->OpenCol('',3);
    $MainOutput->AddTexte(ANTERIOR_BALANCE);
$MainOutput->CloseCol();

$MainOutput->OpenCol();
    $MainOutput->AddTexte("");
$MainOutput->CloseCol();

$MainOutput->OpenCol();
    $MainOutput->AddTexte(number_format($SoldeAnterieur,2)." $");
$MainOutput->CloseCol();

$MainOutput->CloseRow();
    
        
    
    $MainOutput->OpenRow();
$MainOutput->OpenCol('',5);
    $MainOutput->AddTexte("<br>");
$MainOutput->CloseCol();


$MainOutput->CloseRow();
    
}

foreach($FactArray as $entry){
    
    
    $MainOutput->OpenRow();
$MainOutput->OpenCol();
    $MainOutput->AddTexte(datetostr($entry['Date']));
$MainOutput->CloseCol();
$MainOutput->OpenCol();
    $MainOutput->AddTexte($entry['Detail']);
$MainOutput->CloseCol();
$MainOutput->OpenCol();
if($entry['ARec']<>"")
    $MainOutput->AddTexte(number_format($entry['ARec'],2)." $");
$MainOutput->CloseCol();

$MainOutput->OpenCol();
if($entry['Rec']<>"")
    $MainOutput->AddTexte(number_format($entry['Rec'],2)." $");
$MainOutput->CloseCol();

$MainOutput->OpenCol();
    $MainOutput->AddTexte(number_format($entry['Solde'],2)." $");
$MainOutput->CloseCol();

$MainOutput->CloseRow();
    
    
}




}


echo $MainOutput->Send(1);
?>
