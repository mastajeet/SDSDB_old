<?PHP
$SQL = new sqlclass();
$SDate = get_last_sunday(0,strtotime("24 june ".get_vars('Boniyear')));
$hou1 = get_last_sunday(0,strtotime("1 september ".get_vars('Boniyear')));
$EDate = strtotime("First monday",$hou1);

	$Req = "select shift.IDEmploye, Nom, Prenom, sum(end-start)/3600 as A,Salaire, SalaireS FROM shift JOIN employe on shift.IDEmploye = employe.IDEmploye WHERE Semaine+86400*Jour<=".$EDate." and Semaine>=".$SDate." AND !Assistant GROUP BY Salaire, IDEmploye  ORDER BY IDEmploye ASC, Salaire ASC";


$SQL->Select($Req);
$SQL2 = new sqlclass();
$IDEmploye = "";
$MainOutput->OpenTable('700');
$MainOutput->OpenRow();

$MainOutput->OpenCol('20');
	$MainOutput->AddTexte('ID','Titre');
$MainOutput->CloseCol();

$MainOutput->OpenCol('100');
	$MainOutput->AddTexte('Nom','Titre');
$MainOutput->CloseCol();

$MainOutput->OpenCol('100');
	$MainOutput->AddTexte('Prenom','Titre');
$MainOutput->CloseCol();

$MainOutput->OpenCol('100');
	$MainOutput->AddTexte('Salaire','Titre');
$MainOutput->CloseCol();

$MainOutput->OpenCol('100');
	$MainOutput->AddTexte('Boni Mrgl','Titre');
$MainOutput->CloseCol();

$MainOutput->OpenCol('50');
	$MainOutput->AddTexte('Nb H','Titre');
$MainOutput->CloseCol();

$MainOutput->OpenCol('80');
	$MainOutput->AddTexte('Bonus','Titre');
$MainOutput->CloseCol();

$MainOutput->OpenCol('70');
	$MainOutput->AddTexte('Pertes','Titre');
$MainOutput->CloseCol();

$MainOutput->OpenCol('80');
	$MainOutput->AddTexte('Rï¿½siduel','Titre');
$MainOutput->CloseCol();

$MainOutput->CloseRow();

$OPEN = FALSE;
$TBONUS =0;
$TDED =0;
$TNBH = 0 ;
while($Rep = $SQL->FetchArray()){

	if($IDEmploye<>$Rep['IDEmploye']){

		if($OPEN){

			$MainOutput->OpenCol();
				$MainOutput->AddTexte(NUMBER_FORMAT($NBH,2));
			$MainOutput->CloseCol();

	
			$MainOutput->OpenCol();
				$MainOutput->AddTexte(number_format($BONUS,2)." $");
			$MainOutput->CloseCol();

			
			$Req2 = "SELECT sum(Pourcentage) FROM bonicrusher WHERE IDEmploye = ".$IDEmploye." AND Boniyear=".get_vars('Boniyear');
			$SQL2->Select($Req2);
			$Rep2 = $SQL2->FetchArray();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte(round(min($Rep2[0],1)*100,2)." %");
			$MainOutput->CloseCol();
			$TBONUS = $TBONUS+$BONUS;		
			$TNBH = $TNBH+$Rep['A'];	
			$TDED = round(min($Rep2[0],1),2)*$BONUS + $TDED;
			$MainOutput->OpenCol();

				$MainOutput->AddTexte(number_format((1-min($Rep2[0],1))*$BONUS,2)." $");

			$MainOutput->CloseCol();
			
			$MainOutput->CloseRow();
		}

	$IDEmploye = $Rep['IDEmploye'];
	$OPEN = TRUE;
	$BONUS = 0;
	$NBH = 0;

	$MainOutput->OpenRow();

	$MainOutput->OpenCol();
		$MainOutput->AddLink("index.php?Section=Employe_Summer&IDEmploye=".$Rep['IDEmploye'],$Rep['IDEmploye']);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte($Rep['Nom']);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte($Rep['Prenom']);
	$MainOutput->CloseCol();

       	$MainOutput->OpenCol();
		$MainOutput->AddTexte(number_format($Rep['SalaireS'],2)." $");
	$MainOutput->CloseCol();
                
       	$MainOutput->OpenCol();
		$MainOutput->AddTexte(number_format( (1 - 0.04*$Rep['SalaireS']) / 1.04,2)." $");
	$MainOutput->CloseCol();

	}

	if($Rep['Salaire']==0)
            $Rep['Salaire']=$Rep['SalaireS'];
            if($Rep['Salaire']<=$Rep['SalaireS']){
                $BONUS = $BONUS + (1 - 0.04*$Rep['Salaire']) / 1.04*$Rep['A'];
            $NBH = $Rep['A']+$NBH;
            
        }
}
			$TBONUS = $TBONUS+$BONUS;		
			$TNBH = $TNBH+$Rep['A'];
			$TDED = round(min($Rep2[0],1),2)*$BONUS + $TDED;

			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte($NBH);
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte(number_format($BONUS,2)." $");
			$MainOutput->CloseCol();
			
			$Req2 = "SELECT sum(Pourcentage) FROM bonicrusher WHERE IDEmploye = ".$IDEmploye." AND Boniyear=".get_vars('Boniyear');
			$SQL2->Select($Req2);
			$Rep2 = $SQL2->FetchArray();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte(round(min($Rep2[0],1)*100,2)." %");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte(number_format((1-min($Rep2[0],1))*$BONUS,2)." $");
			$MainOutput->CloseCol();
			
			$MainOutput->CloseRow();
			
			
$MainOutput->CloseTable();

$MainOutput->AddTexte('<b>Total Bonus : </b>'.number_format($TBONUS,2).' $ -  <b>Total Coupé : </b>'.number_format($TDED,2)." $");
$MainOutput->br();
$Res = $TBONUS-$TDED;
$MainOutput->AddTexte('<b>Total Heures : </b>'.NUMBER_FORMAT($TNBH,2).' - <b>Total Résiduel : </b>'.number_format($Res,2)." $");


echo $MainOutput->Send(1);
?>