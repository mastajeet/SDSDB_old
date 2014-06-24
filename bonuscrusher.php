<?PHP
if(!$_GET['ToPrint'])
include('bonuscrusher_form.php');


$MainOutput->OpenTable();

if(!$_GET['ToPrint']){
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',4);
	$MainOutput->AddLink('index.php?Section=BoniCrushed&ToPrint=TRUE','Boni Crushed','_BLANK','Titre');
$MainOutput->Closecol();
$MainOutput->CloseRow();
}

$MainOutput->OpenRow();

$MainOutput->OpenCol();
	$MainOutput->AddTexte('No','Titre');
$MainOutput->Closecol();

$MainOutput->OpenCol();
	$MainOutput->AddTexte('Nom','Titre');
$MainOutput->CloseCol();

$MainOutput->OpenCol();
	$MainOutput->AddTexte('Bonus Crushed','Titre');
$MainOutput->Closecol();

$MainOutput->Opencol();
	$MainOutput->AddTexte('Raisons','Titre');
$MainOutput->CloseCol();

$MainOutput->CloseRow();

$Req = "SELECT employe.IDEmploye, Nom, Prenom, sum(Pourcentage) FROM employe JOIN bonicrusher on employe.IDEmploye = bonicrusher.IDEmploye WHERE Boniyear = ".get_vars('Boniyear')." GROUP BY bonicrusher.IDEmploye ORDER BY IDEmploye ASC";
$SQL = new sqlclass();
$SQL2 = new sqlclass();
$Month = get_month_list("court");
$SQL->Select($Req);
$c="four";
while($Rep = $SQL->FetchArray()){


if($c=="three")
	$c="four";
else
	$c="three";

	$MainOutput->OpenRow('',$c);
	$MainOutput->OpenCol('',1,'Top',$c);
		$MainOutput->AddTexte($Rep[0]);
	$MainOutput->CloseCol();
	
	$MainOutput->OpenCol('',1,'Top',$c);
		$MainOutput->AddTexte($Rep[1]." ".$Rep[2]);
	$MainOutput->CloseCol();
	
	$MainOutput->OpenCol('',1,'Top',$c);
	$Pourcentage = min($Rep[3]*100,100);
		$MainOutput->AddTexte(round($Pourcentage,2)." %");
	$MainOutput->CloseCol();
	
	$MainOutput->OpenCol('',1,'Top',$c);
		$Req2 = "SELECT Raison, Description, Date, Pourcentage FROM bonicrusher WHERE IDEmploye = ".$Rep[0]." AND Boniyear = ".get_vars('Boniyear')." ORDER BY Date ASC";
		$SQL2->SELECT($Req2);
		
		$MainOutput->OpenTable();
		while($Rep2 = $SQL2->FetchArray()){
			$Time = get_date($Rep2[2]);
			$MainOutput->OpenRow();
				$MainOutput->OpenCol();
				$Pourcentage = $Rep2[3]*100;
					$MainOutput->AddTexte("<b>".$Time['d']."-".$Month[intval($Time['m'])]."-".$Time['Y']." </b> ".$Rep2[0]." : ".$Rep2[1]." (".$Pourcentage." %)");
				$MainOutput->Closecol();
			$MainOutput->CloseRow();
		}
		$MainOutput->CloseTable();
		
		
	$MainOutput->CloseCol();	
	
}

echo $MainOutput->Send(1);

?>