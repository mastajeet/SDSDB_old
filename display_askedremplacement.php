<?PHP
$Remplacements = get_askedRemplacements($_GET['IDEmploye']);
$MainOutput->OpenTable('450');
$MainOutput->OpenRow();
$MainOutput->OpenCol();
$MainOutput->AddTexte("Demandes de remplacement",'Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->OpenRow();
$MainOutput->OpenCol();
$MainOutput->AddTexte(" ");
$MainOutput->CloseCol();
$MainOutput->CloseRow();


foreach($Remplacements as $v){
	
	
$MainOutput->OpenRow();
$MainOutput->OpenCol();
$MainOutput->AddTexte($v['Installation'],'Titre');
$MainOutput->br();
$MainOutput->AddTexte($v['Date']);
$MainOutput->br();
$MainOutput->AddTexte($v['Raison']);
$MainOutput->CloseCol();
$MainOutput->CloseRow();


}

$MainOutput->CloseTable();

echo $MainOutput->send(1);
?>