<?PHP
/**$MainOutput->OpenTable(250);

$MainOutput->OpenRow();
$MainOutput->OpenCol();
	$MainOutput->AddPic('f_close.png');
	$MainOutput->AddLink('index.php?Section=Horaire','Mon Horaire');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol();
	$MainOutput->AddPic('f_close.png');
	$MainOutput->AddLink('index.php?Section=Info','Mes Infos');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol();
	$MainOutput->AddPic('f_close.png');
	$MainOutput->AddLink('index.php?Section=Confirm_Heures','Confirmer les heures');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol();
	$MainOutput->AddPic('f_close.png');
	$MainOutput->AddLink('index.php?Action=Delog','Se Déconnecter');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->CloseTable();
echo $MainOutput->Send(1);**/
?>