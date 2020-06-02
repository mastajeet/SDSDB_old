<?PHP
$SQL = new sqlclass();
$SQL2 = new sqlclass();
$Req = "select shift.IDEmploye, Nom, Prenom, sum(end-start)/3600 as A,Salaire, SalaireS FROM shift JOIN employe on shift.IDEmploye = employe.IDEmploye WHERE Semaine<=".min(get_last_sunday(2),1188709200)." and Semaine>=1182056400 AND !Assistant GROUP BY IDEmploye ORDER BY IDEmploye ASC, Salaire ASC";
$SQL->SELECT($Req);


$IDEmploye = "";
$MainOutput->OpenTable('500');
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

$MainOutput->OpenCol('50');
	$MainOutput->AddTexte('Nb H','Titre');
$MainOutput->CloseCol();

$MainOutput->OpenCol('160');
	$MainOutput->AddTexte('Chances','Titre');
$MainOutput->CloseCol();

$MainOutput->CloseRow();

$OPEN = FALSE;
$TBONUS =0;
$TDED =0;
$TNBH = 0;
 $c="two";
 

while($Rep = $SQL->FetchArray()){
 


	if($IDEmploye<>$Rep['IDEmploye']){

		if($OPEN){

			$MainOutput->OpenCol('',1,'center',$c);
				$MainOutput->AddTexte(NUMBER_FORMAT($NBH,2));
			$MainOutput->CloseCol();

	
			$MainOutput->OpenCol('',1,'center',$c);
			if($NBH<199){
				$Chances=0;
			}else{
				$Chances=1;
				$Chances = $Chances + floor(max(0,$NBH-200)/40);
			}
				$MainOutput->AddTexte($Chances);
			$MainOutput->CloseCol();
			
			$MainOutput->CloseRow();

if($c=="two")
	$c="one";
else
	$c="two";
		}

	$IDEmploye = $Rep['IDEmploye'];
	$OPEN = TRUE;
	$BONUS = 0;
	$NBH = 0;

	$NBH = $Rep['A'];
	$MainOutput->OpenRow();

	$MainOutput->OpenCol('',1,'center',$c);
		$MainOutput->AddTexte($Rep['IDEmploye']);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('',1,'center',$c);
		$MainOutput->AddTexte($Rep['Nom']);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('',1,'center',$c);
		$MainOutput->AddTexte($Rep['Prenom']);
	$MainOutput->CloseCol();

	}

}

			$MainOutput->OpenCol('',1,'center',$c);
				$MainOutput->AddTexte($NBH);
			$MainOutput->CloseCol();


			$MainOutput->OpenCol('',1,'center',$c);			
			if($NBH<199){
				$Chances=0;
			}else{
				$Chances=1;
				$Chances = $Chances + floor(max(0,$NBH-200)/40);
			}
				$MainOutput->AddTexte($Chances);
				
			$MainOutput->CloseCol();
			
			
			$MainOutput->CloseRow();
			
			
$MainOutput->CloseTable();

echo $MainOutput->Send(1);


?>