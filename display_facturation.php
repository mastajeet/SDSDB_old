<?PHP
const AMOUNT_PAID = " $ (payé)";
const BALANCE_IN_ERROR = 'Débalance';
const DETAIL = 'Détail';
const DEPOSIT = 'Dépot';
const BILLED_TO = 'Facturé à: ';
const PAID = 'Payé';
if(isset($_GET['Cote'])){

$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('60%',5);
if($_GET['ToPrint']){
	$MainOutput->AddPic('logo.jpg');
	$MainOutput->br();
}

	$MainOutput->AddTexte('Installation(s): ','Titre');
	$MainOutput->AddTexte(get_installation_by_cote_in_string($_GET['Cote']));
	$MainOutput->br();
	$MainOutput->AddTexte('Cote: ','Titre');
	$MainOutput->AddTexte($_GET['Cote']);
	$MainOutput->br();	
	$InfoClicli = get_client_info_bycote($_GET['Cote']);
if(!$_GET['ToPrint']){
	if($InfoClicli['Depot']<>0){
	
		$MainOutput->Addlink('http://gestionsds/SDSDB/index.php?Section=Client_Form&IDClient='.$InfoClicli['IDClient'], DEPOSIT,'_BLANK','Titre');
		if($InfoClicli['DepotP'])
			$MainOutput->AddTexte(": ".number_format($InfoClicli['Depot'],2). AMOUNT_PAID);
		else
			$MainOutput->AddTexte(": ".number_format($InfoClicli['Depot'],2)." $",'Warning');
		}else{
		$MainOutput->Addlink('http://gestionsds/SDSDB/index.php?Section=Client_Form&IDClient='.$InfoClicli['IDClient'], DEPOSIT,'_BLANK','Titre');
			$MainOutput->AddTexte(": Aucun");
		}
	}
		$MainOutput->br(2);

if(!isset($_GET['Year']))
	$_GET['Year']=NULL;

	$Info = get_cote_summary($_GET['Cote'],$_GET['Year']);
	$Total = $Info['Total'];
		if(!$_GET['ToPrint']){
	$MainOutput->AddTexte('Sommaire','Titre');

	$MainOutput->br();
	$MainOutput->AddTexte('Sous-Total: ','Titre');
	$MainOutput->AddTexte(number_format($Info['STotal'],2)." $");
	$MainOutput->AddTexte('TPS: ','Titre');
	$MainOutput->AddTexte(number_format($Info['TPS'],2)." $");
	$MainOutput->AddTexte('TVQ: ','Titre');
	$MainOutput->AddTexte(number_format($Info['TVQ'],2)." $");
	$MainOutput->br();
	$MainOutput->AddTexte('-------------------','Titre');
	$MainOutput->br();
	$MainOutput->AddTexte('Total: ','Titre');
	
	$MainOutput->AddTexte(number_format($Total,2)." $");
	$MainOutput->AddLink('index.php?Section=Paiement&Cote='.$_GET['Cote'].'&Year='.$_GET['Year'], PAID,'','Titre');
	$MainOutput->AddTexte(": ".number_format($Info['Paiement'],2)." $");

	$MainOutput->AddTexte(BALANCE_IN_ERROR,'Titre');
	$MainOutput->AddTexte(": ".number_format($Info['SoldeImpaye'] - $Info['Solde'],2)." $");


	$MainOutput->br();
	$MainOutput->AddTexte('-------------------','Titre');
	$MainOutput->br();
	}
	$MainOutput->AddTexte('Solde: ','Titre');
	$MainOutput->AddTexte(number_format($Info['Solde'],2)." $");

$MainOutput->CloseCol();




$MainOutput->OpenCol('',3);
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
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',8);
$MainOutput->br();

	$MainOutput->AddTexte(DETAIL,'Titre');
if(!$_GET['ToPrint']){
	$MainOutput->addlink('index.php?Section=Add_Facture&Cote='.$_GET['Cote'],'<img border=0 src=b_ins.png>');
	$MainOutput->addlink('index.php?Section=Client_DossierFacturation&Cote='.$_GET['Cote'].'&ToPrint=TRUE&NB=15','<img border=0 src=b_print.png>','_BLANK');
	$MainOutput->addlink('index.php?Section=ArchivesFacturation&Cote='.$_GET['Cote'],'<img border=0 src=f_close.png>');
}


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
		$MainOutput->AddTexte('Fac','Titre');
	$MainOutput->CloseCol(100);
		$MainOutput->OpenCol();
		$MainOutput->AddTexte('Sous-Total','Titre');
	$MainOutput->CloseCol(50);
		$MainOutput->OpenCol();
		$MainOutput->AddTexte('TPS','Titre');
	$MainOutput->CloseCol();
		$MainOutput->OpenCol(50);
		$MainOutput->AddTexte('TVQ','Titre');
	$MainOutput->CloseCol();
		$MainOutput->OpenCol(100);
		$MainOutput->AddTexte('Total','Titre');
	$MainOutput->CloseCol();
		$MainOutput->OpenCol(20);
		$MainOutput->AddTexte(AMOUNT_PAID,'Titre');
	$MainOutput->CloseCol();
$MainOutput->CloseRow();
$SQL3 = new sqlclass;

$Info = get_facturation($_GET['Cote'],$_GET['ToPrint'],$_GET['Year']);
foreach($Info as $k =>$v){
	$MainOutput->OpenRow();

		$MainOutput->OpenCol();
				if(!$_GET['ToPrint']){
					$MainOutput->AddLink('index.php?Section=Display_Facture&IDFacture='.$v['IDFacture'].'&ToPrint=TRUE','<img src=b_print.png border=0>','_BLANK','Texte');
					$MainOutput->AddLink('index.php?Section=Modifie_Facture&IDFacture='.$v['IDFacture'],'<img src=b_edit.png border=0>','','Texte');
				}
		$MainOutput->CloseCol();

		$MainOutput->OpenCol();
		$Date = get_date($v['Date']);
			$MainOutput->AddTexte($Date['d']."-".$Date['m']."-".$Date['Y']);
		$MainOutput->CloseCol();
		$MainOutput->OpenCol();
		$Class = 'Warning';
		if($v['Paye'] || $v['Credit'])
			$Class = 'Titre';
		$Credit='';
			if($v['Credit'])
				$Credit='c';
			$MainOutput->AddTexte($Credit.$_GET['Cote']."-".$v['Sequence'],$Class);
		$MainOutput->CloseCol();
			$MainOutput->OpenCol();
			$MainOutput->AddTexte(number_format($v['STotal'],2)." $");
		$MainOutput->CloseCol();
			$MainOutput->OpenCol();
			$MainOutput->AddTexte(number_format($v['TPS'],2)." $");
		$MainOutput->CloseCol();
			$MainOutput->OpenCol();
			$MainOutput->AddTexte(number_format($v['TVQ'],2)." $");
		$MainOutput->CloseCol();
			$MainOutput->OpenCol();
			$MainOutput->AddTexte(number_format($v['Total'],2)." $");
		$MainOutput->CloseCol();
			$MainOutput->OpenCol();
			
			if($v['Credit'])
				$MainOutput->AddTexte('N/A','Titre'); //METTRE LA DATE OU ENCORE LE NUM?RO DE D?POT OU LE NUM?RO DE CHEQUE...
			elseif($v['Paye'] && !$v['Credit']){
				$Req = "SELECT Date FROM paiement WHERE Notes LIKE '%~".$_GET['Cote']."-".$v['Sequence']."~%'";
				$SQL3->SELECT($Req);
				$Rep3 = $SQL3->FetchArray();
				$DatePaid = get_date($Rep3[0]);
				$month = get_month_list('long');
				$MainOutput->AddTexte($DatePaid['d']." ".$month[intval($DatePaid['m'])]." ".$DatePaid['Y'],'Titre'); //METTRE LA DATE OU ENCORE LE NUM?RO DE D?POT OU LE NUM?RO DE CHEQUE...
			}
			
		$MainOutput->CloseCol();
	$MainOutput->CloseRow();

}
$MainOutput->CloseTable();
}else{
$MainOutput->AddForm('Ouvrir le dossier de Facturation','index.php','GET','');
$SQL = new sqlclass;
$Req = "SELECT distinct Cote FROM installation WHERE Actif ORDER BY Cote ASC";
$SQL->SELECT($Req);
$Opt = array();
while($Rep = $SQL->FetchArray()){
	$Ins = get_installation_by_cote_in_string($Rep[0]);
	$Opt[$Rep[0]] = $Rep[0].": ".$Ins;
}

$MainOutput->inputhidden_env('Section','Display_Facturation');
$MainOutput->inputselect('Cote',$Opt);
$MainOutput->FormSubmit('Ouvrir');
}


echo $MainOutput->Send(1);
?>
