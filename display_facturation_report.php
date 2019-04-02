<?PHP

//Variable passed by controler
// - $year_to_display (array of timestamp)
// - $balance_per_customer (list of dictionnaries of customer_name, cote, balance) (should that be converted to dto for reusage?
// - $current_year (int of the current year)
// - $total_recevable (flaot)

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
    $week_end_points = $time_service->get_week_endpoints_from_timestamp($Rep[0]);
    $start_of_week = $time_service->convert_datetime_to_string_using_locale($week_end_points['start_of_week'], J_MMMM_YYYY);
    $end_of_week = $time_service->convert_datetime_to_string_using_locale($week_end_points['end_of_week'], J_MMMM_YYYY);
		$MainOutput->Addtexte($start_of_week.' au '.$end_of_week,'Titre');
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
$MainOutput->AddTexte('Recevables',"titre");
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
foreach(array_reverse($year_to_display) as $year){
    $MainOutput->addlink('index.php?MenuCat=Facture_DisplayFacturationReport&ToPrint=TRUE&year='.$year, $year);
    $MainOutput->AddTexte(' |');
}
$MainOutput->CloseCol();
$MainOutput->CloseRow();

foreach($customer_dtos as $customer_dto){
    $row_display_class = ((!isset($row_display_class) or $row_display_class=="four") ? "three" : "four");

    $MainOutput->OpenRow('',$row_display_class);
    $MainOutput->OpenCol('75%',1,'top',$row_display_class);
    $MainOutput->addlink('index.php?Section=DossierFacturation_DisplayAccountStatement&Cote='.$customer_dto['cote'].'&ToPrint=TRUE&number_of_shown_transactions=15&year='.$current_year,$customer_dto['name'],"_BLANK");
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('25%',1,'top',$row_display_class);
    $MainOutput->AddTexte(number_format($customer_dto['balance'],2)." $");
    $MainOutput->CloseCol();
}

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->AddTexte('&nbsp;');
$MainOutput->Closecol();
$MainOutput->CloseRow();


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->AddTexte('Total: '.round($total_recevable ,2)." $",'Titre');
$MainOutput->Closecol();
$MainOutput->CloseRow();

$MainOutput->CloseTable();
echo $MainOutput->Send(1);
?>