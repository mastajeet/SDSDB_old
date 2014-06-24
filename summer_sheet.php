<?PHP
$SQL = new sqlclass;
$Req = "SELECT IDEmploye, Nom, Prenom, Telp, Session FROM employe where !cessation ORDER BY Nom, Prenom";
$SQL->select($Req);
$MainOutput->OpenTable();


	$MainOutput->OpenRow();
		$MainOutput->OpenCol();
			$MainOutput->AddTexte('No','Titre');
		$MainOutput->CloseCol();
		$MainOutput->OpenCol(120);
			$MainOutput->AddTexte('Nom','Titre');
		$MainOutput->CloseCol();
		$MainOutput->OpenCol(120);
			$MainOutput->AddTexte('Prénom','Titre');
		$MainOutput->CloseCol();
		$MainOutput->OpenCol(60);
			$MainOutput->AddTexte('Tel','Titre');
		$MainOutput->CloseCol();	
		$MainOutput->OpenCol(60);
			$MainOutput->AddTexte('Session','Titre');
		$MainOutput->CloseCol();
		
		
		$MainOutput->OpenCol(600);
			$MainOutput->AddTexte('Shift d\'automne','Titre');
		$MainOutput->CloseCol();
		
		
	$MainOutput->CloseRow();
$c="four";
while($v = $SQL->FetchArray()){
	
if($c=="four")
	$c="three";
else
	$c="four";
	


	
	$MainOutput->OpenRow('20',$c);
	 	$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->AddTexte($v[0]);
		$MainOutput->CloseCol();
	 	$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->AddTexte($v[1]);
		$MainOutput->CloseCol();
	 	$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->AddTexte($v[2]);
		$MainOutput->CloseCol();
		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->AddPhone($v[3]);
			$MainOutput->BR();
		$MainOutput->CloseCol();
	 	$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->AddTexte($v[4]);
			$MainOutput->BR();
		$MainOutput->CloseCol();
		
		
		
		
		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->AddTexte("&nbsp;");
		$MainOutput->CloseCol();
		
		
	$MainOutput->CloseRow();

}

$MainOutput->CloseTable();

echo $MainOutput->Send(1);
?>