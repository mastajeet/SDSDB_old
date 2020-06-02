<?PHP
$SQL = new sqlclass;
$Info = get_facture_info($_GET['IDFacture']);
$Req = "DELETE FROM facture WHERE IDFacture=".$_GET['IDFacture'];
$SQL->Query($Req);
$Req = "DELETE FROM factsheet WHERE IDFacture=".$_GET['IDFacture'];
$SQL->Query($Req);

//Check si attaché à une inspection
$Req = "SELECT IDInspection FROM inspection WHERE IDFacture = ".$_GET['IDFacture'];
$SQL->Query($Req);
if($SQL->NumRow()){
	$Rep = $SQL->FetchArray();
	$Req = "UPDATE inspection SET IDFacture = NULL WHERE IDInspection =".$Rep['IDInspection'];
	$SQL->Query($Req);
}

$_GET['Cote'] = $Info['Cote'];
$Section='Display_Facturation';
?>