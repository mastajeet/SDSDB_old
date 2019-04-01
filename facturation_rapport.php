<?PHP
$TOLERANCE = 0.10;
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

$this_year = get_vars("Boniyear");
$last_year = $this_year-1;
$two_years_ago = $this_year-2;
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->addlink('index.php?MenuCat=Rapport&ToPrint=TRUE&Year='.$two_years_ago, $two_years_ago);
$MainOutput->AddTexte(' - ');
$MainOutput->addlink('index.php?MenuCat=Rapport&ToPrint=TRUE&Year='.$last_year, $last_year);
$MainOutput->AddTexte(' - ');
$MainOutput->addlink('index.php?MenuCat=Rapport&ToPrint=TRUE&Year='.$this_year, $this_year);
$MainOutput->CloseCol();
$MainOutput->CloseRow();

if(!isset($_GET['Year'])){
    $current_year=$this_year;
}else{
    $current_year=$_GET['Year'];
}

$Req = "SELECT IDClient, Nom, Cote FROM client ORDER BY Nom ASC";
$SQL->SELECT($Req);
$YearStamp = mktime(0,0,0,1,1,intval(date("Y")));


$SQL2 = new SQLclass();
$SQL3 = new sqlclass();
$Total = 0;

$c="four";
while($Rep = $SQL->FetchArray()){


    $dossier_facturation= new DossierFacturation($Rep['Cote'], $current_year);
    $solde = $dossier_facturation->get_balance_details();
    $Balance = $solde['balance'];

    if(abs($Balance)>$TOLERANCE){
    if($c=="four")
        $c="three";
    else
        $c="four";


        $MainOutput->OpenRow('',$c);
        $MainOutput->OpenCol('75%',1,'top',$c);
            $MainOutput->addlink('index.php?Section=Client_DossierFacturation&Cote='.$Rep['Cote'].'&ToPrint=TRUE&number_of_shown_transactions=15&year='.$current_year,$Rep[1],"_BLANK");
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