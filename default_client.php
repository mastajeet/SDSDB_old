<?PHP
$SQL = new sqlclass;
$SQL2 = new sqlclass;


$MainOutput->OpenTable(490);
$MainOutput->OpenRow();
$MainOutput->OpenCol(490,5);
$MainOutput->AddTexte('Zone Clients','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();




$MainOutput->OpenRow();
$MainOutput->OpenCol(490,5);
$MainOutput->AddLink('index.php?Section=Client_Form','Ajouter un client');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->OpenRow();
$MainOutput->OpenCol(490,5);
$MainOutput->AddLink('index.php?Section=Client_ActivateInactivate','Activer / Inactiver un client ');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->OpenRow();
$MainOutput->OpenCol(490,5);
$MainOutput->AddLink('index.php?Section=Rapport_ClientComment','Rapport client');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol(490,5);
$MainOutput->AddLink('index.php?Section=Bottin_Responsable','Bottin des responsables');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->CloseTable(490);

echo $MainOutput->send(1);
?>