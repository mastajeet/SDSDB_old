<?PHP
$SQL = new sqlclass;
$SQL2 = new sqlclass;

$Req1 = "SELECT IDClient, Nom, Actif FROM client ORDER BY Nom ASC";
$SQL->SELECT($Req1);

$MainOutput->OpenTable(490);

$MainOutput->OpenRow();
$MainOutput->OpenCol(20);
	$MainOutput->AddPic('carlos.gif','width=20, height=1');
$MainOutput->CloseCol();
$MainOutput->OpenCol(20);
	$MainOutput->AddPic('carlos.gif','width=20, height=1');
$MainOutput->CloseCol();
$MainOutput->OpenCol(300);
	$MainOutput->AddPic('carlos.gif','width=300, height=1');
$MainOutput->CloseCol();
$MainOutput->OpenCol(30);
	$MainOutput->AddPic('carlos.gif','width=30, height=1');
$MainOutput->CloseCol();
$MainOutput->OpenCol(120);
	$MainOutput->AddPic('carlos.gif','width=120, height=1');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol(490,5);
	$MainOutput->AddLink('index.php?Section=Client_Form','Ajouter un client');
	$MainOutput->AddTexte('/');
	$MainOutput->AddLink('index.php?Section=Rapport_ClientComment','Rapport client');
	$MainOutput->AddTexte('/');
	$MainOutput->AddLink('index.php?Section=Bottin_Responsable','Bottin des responsables');
$MainOutput->CloseCol();
$MainOutput->CloseRow();



$c="two";
while($Rep = $SQL->FetchArray()){
if($c=="two")
	$c="one";
else
	$c="two";

	$MainOutput->OpenRow('',$c);
	$MainOutput->OpenCol(20);
		$MainOutput->AddPic('f_cat.png');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol(320,2);
		$MainOutput->AddLink('index.php?MenuClient='.$Rep[0],$Rep[1],'','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol(140,2);
	if($Rep[2])
		$MainOutput->AddLink('index.php?Action=Activate&IDClient='.$Rep[0].'&Activate=FALSE','Actif');
	else
		$MainOutput->AddLink('index.php?Action=Activate&IDClient='.$Rep[0].'&Activate=TRUE','Innactif');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$Req2 = "SELECT IDInstallation, Nom, Actif, Saison,Cote FROM installation WHERE IDClient = ".$Rep[0]." ORDER BY Nom ASC";
	$SQL2->SELECT($Req2);
	while($Rep2 = $SQL2->FetchArray()){
	$MainOutput->OpenRow('',$c);
	$MainOutput->OpenCol(20);
		$MainOutput->AddTexte('&nbsp;');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol(20);
		$MainOutput->AddPic('f_close.png');
	$MainOutput->CloseCol();
		$MainOutput->OpenCol(300);
		$MainOutput->AddLink('index.php?MenuInstallation='.$Rep2[4],$Rep2[1],'','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol(30);
	if($Rep2[2])
		$MainOutput->AddLink('index.php?Action=Activate&IDInstallation='.$Rep2[0].'&Activate=FALSE','Actif');
	else
		$MainOutput->AddLink('index.php?Action=Activate&IDInstallation='.$Rep2[0].'&Activate=TRUE','Innactif');
	$MainOutput->CloseCol();
		$MainOutput->OpenCol(120);
	if($Rep2[3])
		$MainOutput->AddLink('index.php?Action=Activate&IDInstallation='.$Rep2[0].'&Saison=FALSE','En saison');
	else
		$MainOutput->AddLink('index.php?Action=Activate&IDInstallation='.$Rep2[0].'&Saison=TRUE','Hors-Saison');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	}
}
echo $MainOutput->send(1);
?>