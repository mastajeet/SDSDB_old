<?PHP
$OldTStart = 0;
$OldTEnd = 0;
if(isset($_GET['IDInstallation'])){

	$Info2 = get_horaire_info($_GET['IDInstallation']);
	
	$MainOutput->opentable();
	$MainOutput->openrow();
	$MainOutput->opencol('100%',7);
	$MainOutput->addtexte('<div align=center>'.$Info2['Nom'].'</div>','Titre');
	$MainOutput->closecol();
	$MainOutput->closerow();
	
	$MainOutput->openrow();
	$MainOutput->opencol('100%',7);
	$MainOutput->addlink('index.php?Section=Generate_Day&IDHoraire='.$Info2['IDHoraire'],'Générer l\'horaire d\'une journée');
	$MainOutput->closecol();
	$MainOutput->closerow();
	
	
	$MainOutput->openrow();
	for($d=0;$d<=6;$d++){
		$TStart = 0;
		$TEnd = 0;
		$OldTStart = 0;
		$OldTEnd = 0;
		
		$MainOutput->opencol('14.3%');
	$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
			$Info = get_day_shift($Info2['IDHoraire'],$d);
			$MainOutput->opentable();
				$MainOutput->openrow();
				$MainOutput->opencol();
					$MainOutput->addtexte($CJour[$d], 'Titre');
				$MainOutput->closecol();
				$MainOutput->closerow();
			foreach($Info as $v){
				$MainOutput->openrow();
				$MainOutput->opencol();
				$Start = get_date($v['Start']);
				$End = get_date($v['End']);
				
				if($Start['i']==0)
					$Start['i']="";
				if($End['i']==0)
					$End['i']="";
				
				
				$TStart = 60*($Start['i']+60*$Start['G']);
				$TEnd = 60*($End['i']+60*$End['G']);

				if($TStart<$OldTEnd){
				$MainOutput->opentable();
				$MainOutput->openrow();
				$MainOutput->opencol();
					$MainOutput->addtexte('Assistant', 'Titre');
				$MainOutput->closecol();
				$MainOutput->closerow();
				$MainOutput->closetable();
				
				}

				$MainOutput->addtexte($Start['G']."h".$Start['i']." à ".$End['G']."h".$End['i'], 'Titre');
				
				$OldTStart = $TStart;
				$OldTEnd = $TEnd;
				
				
				
				$MainOutput->AddLink('index.php?Section=Horshift_Form&IDHorshift='.$v['IDHorshift'],'<img src=b_edit.png border=0>');
				$MainOutput->closecol();
				$MainOutput->closerow();

				$MainOutput->openrow();
					$MainOutput->opencol();
						$SQL2 = new sqlclass;
						$Req2 = "SELECT Nom, Prenom FROM employe WHERE IDEmploye = '".$v['IDEmploye']."'";
						$SQL2->Query($Req2);
						$Rep2 = $SQL2->FetchArray();
						$MainOutput->addtexte($Rep2[1]." ".$Rep2[0]);
					$MainOutput->closecol();
					$MainOutput->closerow();
							
				$MainOutput->openrow();
				$MainOutput->opencol();
					$MainOutput->addtexte(" ");
				$MainOutput->closecol();
				$MainOutput->closerow();
				
			}
			$MainOutput->closetable();
		$MainOutput->closecol();
	}
	$MainOutput->closerow();
	$MainOutput->closetable();
	echo $MainOutput->send(1);
}