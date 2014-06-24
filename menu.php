<?PHP
$MainOutput->addtexte('Clients','Titre');
$MainOutput->br();
$MainOutput->addlink('index.php?Section=Responsable_Form','Ajouter une personne responsable
');
$MainOutput->addlink('index.php?Section=Client_Form','Ajouter un client
');
$MainOutput->addlink('index.php?Section=Installation_Form','Ajouter une installation
');
$MainOutput->addlink('index.php?Section=Display_Client','Afficher les clients
');
$MainOutput->addlink('index.php?Section=Display_Facturation','Afficher les dossiers de facturation
');

$MainOutput->br();
$MainOutput->addtexte('Horaire','Titre');
$MainOutput->br();

$MainOutput->addlink('index.php?Section=Horaire','Créer un horaire
');
$MainOutput->addlink('index.php?Section=Horshift','Consulter/Modifier un horaire
');
$MainOutput->addlink('index.php?Section=Copy_Horaire','Copier Horaire Officiel sur Réel
');




$MainOutput->br();
$MainOutput->addtexte('Employé','Titre');
$MainOutput->br();


$MainOutput->addlink('index.php?Section=Employe','Ajouter un Employé
');
$MainOutput->addlink('index.php?Section=EmployeList','Liste Employé
');
$MainOutput->addlink('index.php?Section=Add_Qualif','Ajouter une qualification
');


$MainOutput->br();
$MainOutput->addtexte('Paye','Titre');
$MainOutput->br();


$MainOutput->addlink('index.php?Section=Add_Paye','Ajouter une période de paye
');
$MainOutput->addlink('index.php?Section=Display_Timesheet','Afficher une paye
');
$MainOutput->addlink('index.php?Section=Calcul_Ferie','Calculer un férié
','_BLANK');


$MainOutput->br();
$MainOutput->addtexte('Saison','Titre');
$MainOutput->br();

$MainOutput->addlink('index.php?Section=Add_Saison','Ajouter une saison
');
$MainOutput->addlink('index.php?Section=Close_Saison','Fermer une saison
');



$MainOutput->br();

$SQL = new sqlclass;


if(!isset($_GET['Semaine'])){
	$_GET['Semaine']=get_last_sunday();
}
$Upper = intval($_GET['Semaine']+6*604800);
$Lower = intval($_GET['Semaine']-6*604800);
$ThisWeek = get_last_sunday();
$Time = get_date($ThisWeek);
$Time2 = get_date($ThisWeek + 6*(86400));
	$Month = get_month_list('court');
$Req = "SELECT DISTINCT semaine FROM shift WHERE semaine <= ".$Upper." && semaine>= ".$Lower." ORDER by semaine DESC";
$SQL->SELECT($Req);
$MainOutput->Addtexte('Horaire de session','Titre');
$MainOutput->br();
$MainOutput->Addtexte('Semaine courante');
$MainOutput->br();
$MainOutput->addlink('index.php?Section=Display_Shift&Semaine='.$ThisWeek,$Time['d']."-".$Month[intval($Time['m'])]."-".$Time['Y']." au ".$Time2['d']."-".$Month[intval($Time2['m'])]."-".$Time2['Y']);
$MainOutput->br();
$MainOutput->Addtexte('Autres semaines');
$MainOutput->br();
while($Rep=$SQL->FetchArray()){
	$Time = get_date($Rep[0]);
	$Time2 = get_date($Rep[0] + 6*(86400));
	$MainOutput->addlink('index.php?Section=Display_Shift&Semaine='.$Rep[0],$Time['d']."-".$Month[intval($Time['m'])]."-".$Time['Y']." au ".$Time2['d']."-".$Month[intval($Time2['m'])]."-".$Time2['Y']);
	$MainOutput->br();
}


echo $MainOutput->send(1);


?>

