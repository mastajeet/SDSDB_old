<?PHP
$SQL = new sqlclass;
if(!isset($_GET['FORMIDPaye'])){

	$MainOutput->AddForm('Vérifier une paye','index.php','GET');
	$MainOutput->inputhidden_env('Section','Display_Timesheet');
	$Opt = array();
	$Req = "SELECT IDPaye, Semaine1, No FROM paye ORDER BY Semaine1 DESC LIMIT 0,26";
	$SQL->SELECT($Req);
	while($Rep = $SQL->FetchArray()){
		$Sem = get_end_dates(1,$Rep[1]);
		$Opt[$Rep[0]] = "#".$Rep[2]." : ".$Sem['Start']." au ".$Sem['End'];
	}
	$MainOutput->inputselect('IDPaye',$Opt,'0','Paye Allant du');
	$MainOutput->formsubmit('Afficher');
}else{
	if(!isset($_GET['ToPrint'])){
		$_GET['ToPrint'] = FALSE;
	}
	$TestOutput = new HTMLContainer();
	$VerifCash = 0;
	$VerifHeures = 0;
	$FERIE1=FALSE;
	$FERIE2=FALSE;
	$SQL = new sqlclass;
	$SQL2 = new sqlclass;
//	$Req = "SELECT employe.IDEmploye, Nom, Prenom, timesheet.Salaire, S10,S11,S12,S13,S14,S15,S16,S20,S21,S22,S23,S24,S25,S26, timesheet.Ajustement,Heures FROM timesheet JOIN employe ON timesheet.IDEmploye = employe.IDEmploye WHERE IDPaye = '".$_GET['FORMIDPaye']."' AND S10+S11+S12+S13+S14+S15+S16+S20+S21+S22+S23+S24+S25+S26+timesheet.Ajustement<>0 && Salaire<>0 ORDER BY timesheet.IDEmploye ASC";
    $Req = "SELECT IDEmploye, timesheet.Salaire, S10,S11,S12,S13,S14,S15,S16,S20,S21,S22,S23,S24,S25,S26, timesheet.Ajustement, Heures FROM timesheet WHERE IDPaye = '".$_GET['FORMIDPaye']."' AND S10+S11+S12+S13+S14+S15+S16+S20+S21+S22+S23+S24+S25+S26+timesheet.Ajustement<>0 && Salaire<>0 ORDER BY timesheet.IDEmploye ASC";
    $SQL->SELECT($Req);
	$SQL2->SELECT("SELECT Semaine1, No FROM paye WHERE IDPaye = '".$_GET['FORMIDPaye']."'");
	$Rep = $SQL2->FetchArray();
	$Semaine1 = $Rep[0];
	$EndDate = get_end_dates(1,$Semaine1);
	// ON SE CLANCHE LE GROS HEADER SALE AVEC OU SANS LES F?RI?S BLABALBLA
	
	
	IF(!$_GET['ToPrint']){
 	$MainOutput->OpenTable('100%');
	$MainOutput->OpenRow();
 	$MainOutput->OpenCol('100%',21);
		$MainOutput->addlink('index.php?Section=Display_Timesheet&FORMIDPaye='.$_GET['FORMIDPaye'].'&ToPrint=TRUE', '<img border=0 src=assets/buttons/b_print.png>','_BLANK');
		$MainOutput->addlink('index.php?Action=Delete_Timesheet&IDPaye='.$_GET['FORMIDPaye'], '<img border=0 src=assets/buttons/b_del.png>');
		$MainOutput->addlink('index.php?Section=Ajustement&IDPaye='.$_GET['FORMIDPaye'], '<img border=0 src=assets/buttons/b_ins.png>');
		$MainOutput->addtexte('<div align=Center>Feuille de temps de la paye #'.$Rep[1].' allant du '.$EndDate['Start'].' au '.$EndDate['End'].'</div>');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();	
	}else{
	$MainOutput->OpenTable('60%');
	$MainOutput->OpenRow();
 	$MainOutput->OpenCol('100%',9);
		$MainOutput->addtexte('<div align=Center>Paye #'.$Rep[1].' : '.$EndDate['Start'].' au '.$EndDate['End'].'</div>');
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
			$MainOutput->Addtexte('Prénom','Titre');
		$MainOutput->CloseCol();
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('TXH','Titre');
		$MainOutput->CloseCol();

	foreach(array('0'=>'Dim','1'=>'Lun','2'=>'Mar','3'=>'Mer','4'=>'Jeu','5'=>'Ven','6'=>'Sam') as $k=>$v){
		$TestOutput->OpenCol();
			if(is_ferie($Semaine1+$k*86400) AND $_COOKIE['CIESDS']=="QC" ){
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
			if(is_ferie($Semaine1+($k+7)*86400) AND $_COOKIE['CIESDS']=="QC"  ){
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
	
	if(!$_GET['ToPrint']){

		if($FERIE2 || $FERIE1){
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('Ferié','Titre');
		$MainOutput->CloseCol();
		}
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('Ajust.','Titre');
		$MainOutput->CloseCol();
	

	}

	
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('Total','Titre');
		$MainOutput->CloseCol();	
			
		$MainOutput->OpenCol();
			$MainOutput->Addtexte('Total&nbsp;$$','Titre');
		$MainOutput->CloseCol();
		
	$MainOutput->CloseRow();

	// OK LE HEADER EST BIN BEAU ON CLANCHE LE DATA POUR CHAQUE EMPLOY? ET SALAIRE
	
	
$c = "two";
$OldID=0;
$Total=0;
	while($Rep = $SQL->FetchArray()){
	$VALUE="";

if($OldID<>$Rep['IDEmploye']){
	$Total =0;
	$OldID = $Rep['IDEmploye'];
}
if($c=="two")
	$c="one";
else
	$c="two";
	
		$employe = new Employee($Rep['IDEmploye']) ;

        $MainOutput->OpenRow('',$c);

        $MainOutput->OpenCol('',1,'top',$c);
        $MainOutput->addtexte($employe->IDEmploye,'Titre');
        $MainOutput->CloseCol();

        $MainOutput->OpenCol('',1,'top',$c);
        $MainOutput->addtexte($employe->Nom);
        $MainOutput->CloseCol();

        $MainOutput->OpenCol('',1,'top',$c);
        $MainOutput->addtexte($employe->Prenom);
        $MainOutput->CloseCol();
		
		$Ferie1=0;
		$Sum1=0;
		
		for($i=0;$i<=6;$i++){	
			
			if(!$_GET['ToPrint']){
				$MainOutput->OpenCol('',1,'top',$c);
					if($Rep['S1'.$i]<>0){
							$MainOutput->AddTexte('<div align=center>'.$Rep['S1'.$i].'</div>');
						}else{
							$MainOutput->AddTexte('&nbsp;');
						}
				$MainOutput->CloseCol();
			}
			
			if(is_ferie($Semaine1+$i*86400) AND $_COOKIE['CIESDS']=="QC"  ){
				$Ferie1 = $Rep['S1'.$i];
			}else{
				$Sum1 = $Sum1 + $Rep['S1'.$i];
			}
		}
		
		
		if($FERIE1){
			$MainOutput->OpenCol('',1,'top',$c);
				$MainOutput->Addtexte($Ferie1,'Warning');
			$MainOutput->CloseCol();	
		}
		
		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->Addtexte($Sum1);
		$MainOutput->CloseCol();

		$Ferie2=0;
		$Sum2=0;
		
				for($i=0;$i<=6;$i++){	
			
			if(!$_GET['ToPrint']){
				$MainOutput->OpenCol('',1,'top',$c);
					if($Rep['S2'.$i]<>0){
							$MainOutput->AddTexte('<div align=center>'.$Rep['S2'.$i].'</div>');
						}else{
							$MainOutput->AddTexte('&nbsp;');
						}
				$MainOutput->CloseCol();
			}
			
			if(is_ferie($Semaine1+($i+7)*86400) AND $_COOKIE['CIESDS']=="QC"  ){
				$Ferie2 = $Rep['S2'.$i];	
			}else{
				$Sum2 = $Sum2 + $Rep['S2'.$i];			
			}
		}
		
		
		if($FERIE2){
			$MainOutput->OpenCol('',1,'top',$c);
				$MainOutput->Addtexte($Ferie2,'Warning');
			$MainOutput->CloseCol();	
		}

	$Heures = $Sum1+$Sum2+$Rep['Ajustement']*$Rep['Heures'];
	$VerifHeures = $VerifHeures+$Heures+$Ferie1+$Ferie2;			
	if($_GET['ToPrint']){
	$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->Addtexte($Sum2+$Rep['Ajustement']*$Rep['Heures']);
		$MainOutput->CloseCol();
	}else{
			$MainOutput->OpenCol('',1,'top',$c);
				$MainOutput->Addtexte($Sum2);
			$MainOutput->CloseCol();
		if(!$FERIE1)
			$Ferie1=0;
		if(!$FERIE2)
			$Ferie2=0;	
		if($FERIE1 || $FERIE2){
			$MainOutput->OpenCol('',1,'top',$c);
				$MainOutput->Addtexte($Ferie1+$Ferie2);
			$MainOutput->CloseCol();
		}
		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->Addtexte($Rep['Ajustement']*$Rep['Heures'],'Titre');
		$MainOutput->CloseCol();
		
		
}
$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->Addtexte($Heures,'Titre');
		$MainOutput->CloseCol();
		
		$Cash = (($Ferie1+$Ferie2)*1.5+$Sum1+$Sum2+$Rep['Ajustement'])*$Rep['Salaire'];
		$Total = $Total + $Ferie1+$Ferie2+$Sum1+$Sum2+$Rep['Ajustement']*$Rep['Heures'];
		$VerifCash = $VerifCash+$Cash;
		$Class="Texte";
				if($Total>80)
			$Class="Warning";
		if($Rep['Heures']==0)
			$Class="Warning";
		
		$MainOutput->OpenCol('',1,'top',$c);
			$MainOutput->Addtexte(number_format($Cash,2)."&nbsp;$",$Class);
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
	
}

echo $MainOutput->send(1);
?>