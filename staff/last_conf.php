<?PHP
$Req = "SELECT IDConfirmation, Nom, Prenom, confirmation.Notes,Semaine FROM confirmation JOIN employe on confirmation.IDEmploye = employe.IDEmploye WHERE 1 ORDER BY semaine DESC Limit 0,1";
$SQL->SELECT($Req);



if($SQL->NumRow()<>0){
$Rep = $SQL->FetchArray()
$ENDS = get_end_dates($Rep);

	$MainOutput->opentable('100%');
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('',8);
		$MainOutput->AddTexte('<div align=center>Heure confirmées : Semaine du '. $ENDS['Start'].' au '.$ENDS['End'] .'</div>','Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->OpenRow('',$c);
	$Sum=0;
	foreach($CJour as $k=>$v){
	$Installation ="";

	$Req2 = "SELECT confshift.Start, confshift.End, Nom, shift.IDShift FROM shift JOIN confshift JOIN installation ON confshift.IDShift = shift.IDShift AND shift.IDInstallation = installation.IDInstallation WHERE confshift.IDConfirmation=".$Rep[0]." AND Jour='".$k."' ORDER BY confshift.Start ASC";
			$SQL2->Select($Req2);
		
			$MainOutput->OpenCol(50);
				$MainOutput->OpenTable();
				$MainOutput->OpenRow();
				
				$MainOutput->OpenCol();
					$MainOutput->Addtexte($v,'Titre');
				$MainOutput->CloseCol();
				
				while($Rep2 = $SQL2->FetchArray()){
					if($Installation <> $Rep2[2]){
						$Installation = $Rep2[2];
						$MainOutput->OpenRow();
						$MainOutput->OpenCol();
							$MainOutput->Addtexte($Installation,'Titre');
						$MainOutput->CloseCol();
						$MainOutput->CloseRow();
					}
						$MainOutput->OpenRow();
						
						$Sh = $Rep2[0]/3600;				
						$Eh = $Rep2[1]/3600;
						$Sum = $Sum+($Eh-$Sh);
						
						
						$MainOutput->OpenCol();
							$MainOutput->Texte($Sh." à ".$Eh);
						$MainOutput->CloseCol();
				}
				$MainOutput->CloseRow();
				
				
				
				
				$MainOutput->CloseTable();
			$MainOutput->CloseCol();
	
	
		}
		
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('Total: '.$Sum.'h','Titre');
			$MainOutput->CloseCol();

		$MainOutput->CloseRow();
	
		$MainOutput->OpenRow('',$c);
		$MainOutput->OpenCol('',8);
			$MainOutput->AddTexte('Notes: ','Titre');
			$MainOutput->AddTexte($Rep[3]);
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
	
		
	$MainOutput->CloseTable();
	
?>
