<?PHP
$MainOutput->OpenTable();
if(!isset($_GET['ToPrint'])){
	$_GET['ToPrint']=False;
}

	$SemD = get_date($_GET['Semaine']);
	$SemE = get_date($_GET['Semaine'] + 6*(86400));
	$Month = get_month_list('court');
	
$Time = $SemD;
$Time2 = $SemE;
$Month = get_month_list('court');

	 $MainOutput->OpenRow();
 	$MainOutput->OpenCol(900,8);
	if(!$_GET['ToPrint']){
		$MainOutput->addlink('index.php?Section=Add_Shift&Semaine='.$_GET['Semaine'],'<img border=0 src=b_ins.png>');
		$MainOutput->addlink('index.php?Section=Display_Shift&Semaine='.$_GET['Semaine'].'&ToPrint=TRUE','<img border=0 src=b_print.png>','_BLANK');
		if($_GET['Semaine'] < get_last_sunday() ){
		$MainOutput->addlink('index.php?Section=Generate_Facture&Semaine='.$_GET['Semaine'],'<img border=0 src=b_fact.png>');
		$MainOutput->addlink('index.php?Section=Conf_Shift&Semaine='.$_GET['Semaine'],'<img border=0 src=b_conf.png>');
		}
	}
		 $MainOutput->addtexte('<div align=Center>Feuille de temps de la semaine du '.$Time['d']."-".$Month[intval($Time['m'])]."-".$Time['Y']." au ".$Time2['d']."-".$Month[intval($Time2['m'])]."-".$Time2['Y'].'</div>','Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	if(!$_GET['ToPrint']){
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('450',1);
		$MainOutput->addoutput('<div align=right>',0,0);
			$MainOutput->AddLink('index.php?Section=Display_Shift&Semaine='.get_last_sunday(2,$_GET['Semaine']),'<<');
		$MainOutput->addoutput('</div>',0,0);
		$MainOutput->CloseCol();
		
			$MainOutput->OpenCol('450',3);
		$MainOutput->addoutput('<div align=left>',0,0);
			$MainOutput->AddLink('index.php?Section=Display_Shift&Semaine='.get_last_sunday(1,$_GET['Semaine']),'Semaine précédente');
		$MainOutput->addoutput('</div>',0,0);
		$MainOutput->CloseCol();
		
		
		$MainOutput->OpenCol('450',3);
		$MainOutput->addoutput('<div align=right>',0,0);
			$MainOutput->AddLink('index.php?Section=Display_Shift&Semaine='.get_next_sunday(0,$_GET['Semaine']),'Semaine Suivante');
		$MainOutput->addoutput('</div>',0,0);
		$MainOutput->CloseCol();
		
		$MainOutput->OpenCol('450',1);
		$MainOutput->addoutput('<div align=left>',0,0);
			$MainOutput->AddLink('index.php?Section=Display_Shift&Semaine='.get_next_sunday(1,$_GET['Semaine']),'>>');
		$MainOutput->addoutput('</div>',0,0);
		$MainOutput->CloseCol();
		
		
		$MainOutput->CloseRow();
	}
	
$MainOutput->OpenRow(1);
$MainOutput->OpenCol(100);
$MainOutput->AddPic('carlos.gif','width=20, height=1');
$MainOutput->CloseCol();
	for($d=0;$d<=6;$d++){
		$MainOutput->OpenCol(112);
		$MainOutput->AddPic('carlos.gif','width=112, height=1');
		$MainOutput->CloseCol();
	}
$MainOutput->CloseRow();


	$MainOutput->OpenRow();
	$MainOutput->OpenCol(100);
	$MainOutput->AddTexte('&nbsp;');
	$MainOutput->CloseCol();
	$MDay = array();
		for($d=0;$d<=6;$d++){
			$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
			$MainOutput->opencol(115);
			$MainOutput->addtexte("<div align=center>".$CJour[$d]."</div>", 'Titre');
			$Date = get_date($_GET['Semaine']+$d*86400);
			$MainOutput->addtexte("<div align=center>".$Date['d']."-".$Month[intval($Date['m'])]."</div>", 'Titre');
			$MDay[$d] = $Date['d']."-".$Month[intval($Date['m'])];
			$MainOutput->closecol();
		}
	$MainOutput->CloseRow();
	
	

	$Req2 = "SELECT DISTINCT  shift.IDInstallation, installation.`Nom`, installation.Cote, installation.Tel FROM shift JOIN installation on installation.IDInstallation = shift.IDInstallation WHERE Semaine = '".$_GET['Semaine']."'  ORDER BY installation.IDClient ASC, installation.Nom ASC";	
	$SQL = new sqlclass;
	$SQL->SELECT($Req2);
	while($Rep = $SQL->FetchArray()){
		
	
		
		
		$MainOutput->openrow();

	$MainOutput->opencol('100%',1,'center','HInstall');
	$MainOutput->addtexte("<div align=center>".$Rep[1]."</div>",'Titre');
	$MainOutput->addtexte("<div align=center>".$Rep[2]."</div>");
	$MainOutput->addoutput('<div align=center>',0,0);
	$MainOutput->addphone($Rep[3]);
	$MainOutput->addoutput('</div>',0,0);
	$MainOutput->closecol();

		
		for($d=0;$d<=6;$d++){
			$TStart = 0;
			$TEnd = 0;
			$OldTStart = 0;
			$OldTEnd = 0;
			
	$CJour = array(0=>'Dim',1=>'Lun',2=>'Mar',3=>'Mer',4=>'Jeu',5=>'Ven',6=>'Sam');			

			
			$MainOutput->opencol('10.0%','1','top','HDay');
			$MainOutput->opentable();
					$MainOutput->openrow();
					$MainOutput->opencol();
						$MainOutput->addtexte('<div align=center>'.$CJour[$d]." ".$MDay[$d].'</div>');
					$MainOutput->closecol();
					$MainOutput->closerow(); 
			$MainOutput->closetable();	
					

				$Info = get_day_shift($Rep[0],array('d'=>$d,'semaine'=>$_GET['Semaine']),"Real");
				$MainOutput->opentable();
					
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
						$MainOutput->addtexte('Assistant', 'Warning');
					$MainOutput->closecol();
					$MainOutput->closerow();
					$MainOutput->closetable();	
					
					}

					$MainOutput->addtexte($Start['G']."h".$Start['i']."&nbsp;à&nbsp;".$End['G']."h".$End['i'], 'Titre2');
					
					$OldTStart = $TStart;
					$OldTEnd = $TEnd;
					
					
					if(!$_GET['ToPrint'])
						$MainOutput->AddLink('index.php?Section=Shift_Form&IDShift='.$v['IDShift'],'<img src=b_edit.png border=0>');
					$MainOutput->closecol();
					$MainOutput->closerow();
					
					$MainOutput->openrow();
					$Diplay="";
					$Class = "safe";
					if($v['Warn']<>""){
						$Class = "warn";
					}
					if($v['IDEmploye']=="0"){
						$Class = "rempl";
					}
					if($v['Confirme']==0 && $v['Semaine'] < get_last_sunday() ){
						$Class = "unconfirmed";
					}
					$MainOutput->opencol('','1','top',$Class);
						$SQL2 = new sqlclass;
						$Req2 = "SELECT Nom, Prenom , HName FROM employe WHERE IDEmploye = '".$v['IDEmploye']."'";
						$SQL2->Query($Req2);
						$Rep2 = $SQL2->FetchArray();
						if($Rep2[2]=="")
							$Display = substr($Rep2[1]."&nbsp;".$Rep2[0],0,20);
						else
							$Display = $Rep2[2];

						$MainOutput->addlink('index.php?Section=Employe&IDEmploye='.$v['IDEmploye'],$Display);
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
	}

$MainOutput->closetable();
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->CloseTable();
	echo $MainOutput->send(1);
	?>
