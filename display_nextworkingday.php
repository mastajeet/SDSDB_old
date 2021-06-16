<?PHP

$SQL = new sqlclass();
$SQL2 = new sqlclass();
$Today = time();
$MainOutput->OpenTable();

	$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',4);
		$MainOutput->AddTexte('Rapport des prochains shiftFormatter','Titre');
		$MainOutput->CloseCol();
	$MainOutput->OpenRow();


	$MainOutput->OpenRow();
		$MainOutput->OpenCol();
		$MainOutput->AddTexte('Employe','Titre');
		$MainOutput->CloseCol();

		$MainOutput->OpenCol();
		$MainOutput->AddTexte('Installation','Titre');
		$MainOutput->CloseCol();

		$MainOutput->OpenCol();
		$MainOutput->AddTexte('Jour','Titre');
		$MainOutput->CloseCol();

		$MainOutput->OpenCol();
		$MainOutput->AddTexte('Heure','Titre');
		$MainOutput->CloseCol();
	$MainOutput->OpenRow();

$Req = "select employe.prenom as prenom, employe.nom as nom, installation.nom as installation, shift.semaine + shift.jour*60*60*24 + shift.Start as DateDuShift, shift.jour, round(shift.start/3600,2) as debut, round(shift.end/3600,2) as fin from shift JOIN employe JOIN installation on shift.IDEmploye = employe.IDEmploye AND installation.IDInstallation = shift.IDInstallation WHERE employe.Session = \"".get_vars('Saison')."\"AND shift.semaine + shift.jour*60*60*24 + shift.Start in (SELECT min(shift.semaine + shift.jour*60*60*24 + shift.Start) FROM shift JOIN employe on shift.IDEmploye = employe.IDEmploye where shift.semaine+shift.jour*24*60*60+shift.Start > ".$Today." and employe.Session = \"".get_vars('Saison')."\" GROUP BY shift.IDEmploye) ORDER BY Employe.Nom ASC, Employe.Prenom ASC" ;

echo $Req;
die();
#echo datetostr(1276405200);
#echo $Today;


$SQL->SELECT($Req);
while($Rep2 = $SQL->FetchArray()){



	$MainOutput->OpenRow();
			$MainOutput->OpenCol();
			$MainOutput->AddTexte($Rep2['nom']." ".$Rep2['prenom']);
			$MainOutput->CloseCol();
			$MainOutput->OpenCol();
			$MainOutput->AddTexte($Rep2['installation']);
			$MainOutput->CloseCol();

			$MainOutput->OpenCol();
			$MainOutput->AddTexte(datetostr($Rep2['DateDuShift']));
			$MainOutput->CloseCol();

			$MainOutput->OpenCol();
			$MainOutput->AddTexte($Rep2['debut']." à ".$Rep2['fin']);
			$MainOutput->CloseCol();


		$MainOutput->OpenRow();
	
}
	$MainOutput->CloseTable();
	echo $MainOutput->send(1);
?>
