<?PHP
if(!isset($_GET['ToPrint'])){
	$_GET['ToPrint'] = FALSE;
	}
if(!isset($_GET['Semaine'])){
	$_GET['Semaine'] = get_last_sunday();
	}
if(!isset($_GET['ENR'])){
	$_GET['ENR'] = FALSE;
	}
	if($_GET['ENR']){
			$Req = "DELETE FROM timesheet WHERE IDPaye = '".$IDPaye."'";
			$SQL->query($Req);
	}
$TestOutput = new HTMLContainer;
$VerifCash = 0;
$VerifHeures = 0;
$FERIE1=FALSE;
$FERIE2=FALSE;
$SQL3 = new sqlclass;
$S1 = $_GET['Semaine'];
$S2 = get_next_sunday(0,$S1);
	
	$SQL = new sqlclass;
	$SQL2 = new sqlclass;
	$Req = "
SELECT DISTINCT employe.IDEmploye, Nom, Prenom, Salaire, SalaireA, SalaireS, shift.Assistant, Semaine
FROM shift
JOIN employe ON shift.IDEmploye = employe.IDEmploye
WHERE semaine = '".$S1."' OR semaine = '".$S2."'
GROUP BY shift.IDEmploye, Assistant, Salaire
ORDER BY shift.IDEmploye ASC
";
	$SQL->SELECT($Req);
	
$ThisWeek = get_last_sunday(0,$S1);
$Time = get_date($ThisWeek);
$Time2 = get_date($ThisWeek + 12*(86400));
$Month = get_month_list('court');

IF(!$_GET['ToPrint']){
 	$MainOutput->OpenTable('100%');
	 $MainOutput->OpenRow();
 	$MainOutput->OpenCol('100%',20);
		$MainOutput->addlink('index.php?Section=TimeSheet&Semaine='.$_GET['Semaine'].'&ToPrint=TRUE', '<img border=0 src=assets/buttons/b_print.png>','_BLANK');
				$MainOutput->addlink('index.php?Section=TimeSheet&Semaine='.$_GET['Semaine'].'&ENR=TRUE', '<img border=0 src=assets/buttons/b_save.png>','_BLANK');
		 $MainOutput->addtexte('<div align=Center>Feuille de temps de la semaine du '.$Time['d']."-".$Month[intval($Time['m'])]."-".$Time['Y']." au ".$Time2['d']."-".$Month[intval($Time2['m'])]."-".$Time2['Y'].'</div>');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();	
	}else{
	$MainOutput->OpenTable('60%');
	 $MainOutput->OpenRow();
 	$MainOutput->OpenCol('100%',8);
		 $MainOutput->addtexte('<div align=Center>Feuille de temps de la semaine du '.$Time['d']."-".$Month[intval($Time['m'])]."-".$Time['Y']." au ".$Time2['d']."-".$Month[intval($Time2['m'])]."-".$Time2['Y'].'</div>');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	}
	$MainOutput->OpenRow();
	
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('No','Titre');
		$MainOutput->CloseCol();
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('Nom','Titre');
		$MainOutput->CloseCol();
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('Pr�nom','Titre');
		$MainOutput->CloseCol();
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('TXH','Titre');
		$MainOutput->CloseCol();


	foreach(array('0'=>'Dim','1'=>'Lun','2'=>'Mar','3'=>'Mer','4'=>'Jeu','5'=>'Ven','6'=>'Sam') as $k=>$v){
		$TestOutput->OpenCol();
			if(is_ferie($S1+$k*86400)){
				$TestOutput->Addtexte('<div align=center>'.$v.'</div>','Warning');
				$FERIE1 = TRUE;
			}else{
				$TestOutput->Addtexte('<div align=center>'.$v.'</div>','Titre');
			}

		$TestOutput->CloseCol();
	}

IF(!$_GET['ToPrint']){
	$MainOutput->addoutput($TestOutput->send(1),0,0);
}

	if($FERIE1){
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('Fer&nbsp;1','Warning');
		$MainOutput->CloseCol();
	}

	$MainOutput->OpenCol();
		$MainOutput->Addtexte('Sem&nbsp;1','Titre');
	$MainOutput->CloseCol();



	foreach(array('0'=>'Dim','1'=>'Lun','2'=>'Mar','3'=>'Mer','4'=>'Jeu','5'=>'Ven','6'=>'Sam') as $k=>$v){
		$TestOutput->OpenCol();
			if(is_ferie($S2+$k*86400)){
				$TestOutput->Addtexte('<div align=center>'.$v.'</div>','Warning');
				$FERIE2 = TRUE;
			}else{
				$TestOutput->Addtexte('<div align=center>'.$v.'</div>','Titre');
			}
		$TestOutput->CloseCol();
	
	}

IF(!$_GET['ToPrint']){
	$MainOutput->addoutput($TestOutput->send(1),0,0);
}


		if($FERIE2){
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('Fer&nbsp;2','Warning');
		$MainOutput->CloseCol();
		}
		
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('Sem&nbsp;2','Titre');
		$MainOutput->CloseCol();
	
	
		if($FERIE2 || $FERIE1){
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('Feri�','Titre');
		$MainOutput->CloseCol();
		}
	
	
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('Total','Titre');
		$MainOutput->CloseCol();
	
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('Total&nbsp;$$','Titre');
		$MainOutput->CloseCol();
		
	$MainOutput->CloseRow();


$c = "two";
	while($Rep = $SQL->FetchArray()){
	
	$VALUE="";
if($c=="two")
	$c="one";
else
	$c="two";
	
		$MainOutput->OpenRow('',$c);

		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->addtexte($Rep['IDEmploye'],'Titre');
		$MainOutput->CloseCol();
		
		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->addtexte($Rep['Nom']);
		$MainOutput->CloseCol();
		
		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->addtexte($Rep['Prenom']);
		$MainOutput->CloseCol();
		
		$Salaire = "";
		if($Rep['Salaire']==0){
			if($Rep['Assistant']==1){
				$Salaire = $Rep['SalaireA'];
			}else{
				$Salaire = $Rep['SalaireS'];
			}
		}else{
			$Salaire = $Rep['Salaire'];
		}
		
		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->Addtexte($Salaire,'Texte');
		$MainOutput->CloseCol();
		
		$Ferie1=0;
		$Sum1=0;
		
		for($i=0;$i<=6;$i++){	
			$Req2 = "SELECT sum(End-Start), Confirme FROM shift WHERE IDEmploye = '".$Rep['IDEmploye']."' && abs(Salaire-".$Rep['Salaire'].")<0.01 && Assistant='".$Rep['Assistant']."' && Semaine='".$S1."' && Jour='$i' GROUP BY IDEmploye";
			$SQL2->SELECT($Req2);
			$Rep2 = $SQL2->FetchArray();
			$NBH = round($Rep2[0]/3600,2);
			
			
			if(!$_GET['ToPrint']){
				$MainOutput->OpenCol('',1,'top',$c);
					if($NBH<>0)
						if($Rep2[1]==1){
							$MainOutput->AddTexte('<div align=center>'.$NBH.'</div>');
							$VALUE = $VALUE." '".$NBH."',";
						}else{
							$MainOutput->AddTexte('<div align=center>'.$NBH.'</div>','unconfirmed');
							$VALUE = $VALUE." '".$NBH."',";
						}else{
							$MainOutput->AddTexte('&nbsp;');
							$VALUE = $VALUE." '0',";
						}
				$MainOutput->CloseCol();
			}
			
			if(!is_ferie($S1+$i*86400)){
				$Sum1 = $Sum1 + $NBH;
			}else{
				$Ferie1 = $NBH;
			}
		}
		
		
		if($FERIE1){
			$MainOutput->OpenCol('',1,'top',$c);
				$MainOutput->Addtexte($Ferie1,'Warning');
			$MainOutput->CloseCol();	
		}
		
		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->Addtexte($Sum1,'Titre');
		$MainOutput->CloseCol();
			
		$Sum2=0;
		
		for($i=0;$i<=6;$i++){	
		$Req2 = "SELECT sum(End-Start), Confirme FROM shift WHERE IDEmploye = '".$Rep['IDEmploye']."' && abs(Salaire-".$Rep['Salaire'].")<0.01 && Assistant='".$Rep['Assistant']."' && Semaine='".$S2."' && Jour='$i' GROUP BY IDEmploye";
		$SQL2->SELECT($Req2);
		$Rep2 = $SQL2->FetchArray();
		$NBH = round($Rep2[0]/3600,2);
		if(!$_GET['ToPrint']){
			$MainOutput->OpenCol('',1,'top',$c);
				if($NBH<>0)
						if($Rep2[0]==1){
							$MainOutput->AddTexte('<div align=center>'.$NBH.'</div>');
							$VALUE = $VALUE." '".$NBH."',";
						}else{
							$MainOutput->AddTexte('<div align=center>'.$NBH.'</div>','unconfirmed');
							$VALUE = $VALUE." '".$NBH."',";
						}
					else{
					$MainOutput->AddTexte('&nbsp;');
					$VALUE = $VALUE." '0',";
								}
			$MainOutput->CloseCol();
		}
		
		if(!is_ferie($S2+$i*86400)){
				$Sum2 = $Sum2 + $NBH;
			}else{
				$Ferie2 = $NBH;
			}
		}
		
		if($FERIE2){
			$MainOutput->OpenCol('',1,'top',$c);
				$MainOutput->Addtexte($Ferie2,'Warning');
			$MainOutput->CloseCol();	
		}
		
		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->Addtexte($Sum2,'Titre');
		$MainOutput->CloseCol();

		$Heures = $Sum1+$Sum2;


if(!$FERIE1)
	$Ferie1=0;
if(!$FERIE2)
	$Ferie2=0;	
	
		$VerifHeures = $VerifHeures+$Heures+$Ferie1+$Ferie2;


if($FERIE1 || $FERIE2){

		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->Addtexte($Ferie1+$Ferie2);
		$MainOutput->CloseCol();

}

		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->Addtexte($Sum1+$Sum2);
		$MainOutput->CloseCol();
		
		if($_GET['ENR']){
			$Req3 = "INSERT INTO timesheet(`IDEmploye`,`Salaire`, `IDPaye`,`S10`,`S11`,`S12`,`S13`,`S14`,`S15`,`S16`,`S20`,`S21`,`S22`,`S23`,`S24`,`S25`,`S26`) VALUES('".$Rep['IDEmploye']."','".$Salaire."','".$IDPaye."',".substr($VALUE,0,-1).")";
			$SQL3->insert($Req3);
		}
		$Cash = (($Ferie1+$Ferie2)*1.5+$Heures)*$Salaire;
		$VerifCash = $VerifCash+$Cash;
		
		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->Addtexte(number_format($Cash,2)."&nbsp;$",'Titre');
		$MainOutput->CloseCol();


		$MainOutput->CloseRow();
	}
	
	
	 IF(!$_GET['ToPrint']){
	 $MainOutput->OpenRow();
 	$MainOutput->OpenCol('100%',20);
		 $MainOutput->addtexte('Total Heures : '.$VerifHeures.' Total Argent: '.number_format($VerifCash,2).'$');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();	
	}else{
	 $MainOutput->OpenRow();
 	$MainOutput->OpenCol('100%',8);
				 $MainOutput->addtexte('<div align=right>Total Heures : '.$VerifHeures.'h ----- Total Argent:  '.number_format($VerifCash,2).'$</div>','Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	}
	
$MainOutput->CloseTable();
	
	
		if($_GET['ENR']){
			$Req = "UPDATE shift SET `Paye`='TRUE' WHERE Semaine = '".$_GET['Semaine']."'";
			$SQL->query($Req);
			$MainOutput->emptyoutput();
	$_GET['FORMIDPaye']=$IDPaye;
	include('display_timesheet.php');
		}else{
			echo $MainOutput->send(1);
		}

	?>