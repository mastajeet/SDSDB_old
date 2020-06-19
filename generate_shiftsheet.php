<?PHP
$SQL = new sqlclass;
$SQL2 = new sqlclass;
$Req = "SELECT IDInstallation, Nom FROM installation WHERE IDClient in(28,29)";
$SQL->SELECT($Req);
$MainOutput->OpenTable();
$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
$Month = get_month_list('court');
while( $Rep = $SQL->FetchArray()){
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte("<div align=center>".$Rep['Nom']."</div>",'Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
	$MainOutput->Opentable();
	
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
	for($s=0;$s<=11;$s++){
		$Semaine = 1182056400 +$s*60*60*24*7;
		//$MainOutput->OpenRow();
		//$MainOutput->OpenCol(100);
		//$MainOutput->AddTexte('&nbsp;');
		//$MainOutput->CloseCol();
		$MDay = array();
		$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
		for($d=0;$d<=6;$d++){
			//$MainOutput->opencol(115);
			//$MainOutput->addtexte("<div align=center>".$CJour[$d]."</div>", 'Titre');
			$Date = get_date($Semaine+$d*86400);
			//$MainOutput->addtexte("<div align=center>".$Date['d']."-".$Month[intval($Date['m'])]."</div>", 'Titre');
			$MDay[$d] = $Date['d']."-".$Month[intval($Date['m'])];
			//$MainOutput->closecol();
		}
		$MainOutput->CloseRow();
		$MainOutput->openrow();
		$MainOutput->opencol('100%',1,'center','HInstall');
		$MainOutput->addtexte("<div align=center>".$Rep[1]."</div>",'Titre');
		$MainOutput->closecol();
		$Req3 = "SELECT IDShift, Jour, Start, End, Warn, Confirme, Assistant, shift.IDEmploye, Nom, Prenom, HName FROM shift LEFT JOIN employe on shift.IDEmploye = employe.IDEmploye WHERE IDInstallation=".$Rep[0]." AND Semaine=".$Semaine."  ORDER BY Jour ASC, Assistant ASC, Start ASC";
		$SQL2->SELECT($Req3);
		$Output = array(0=>new HTMLContainer,1=>new HTMLContainer,2=>new HTMLContainer,3=>new HTMLContainer,4=>new HTMLContainer,5=>new HTMLContainer,6=>new HTMLContainer);
		$Assistant = array(0=>FALSE,1=>FALSE,2=>FALSE,3=>FALSE,4=>FALSE,5=>FALSE,6=>FALSE);
		while($Rep2 = $SQL2->FetchArray()){
			if($Rep2['Assistant'] AND !$Assistant[$Rep2['Jour']]){
				$Output[$Rep2['Jour']]->OpenRow();
				$Output[$Rep2['Jour']]->OpenCol();
				$Output[$Rep2['Jour']]->AddTexte('Assistant','Warning');
				$Output[$Rep2['Jour']]->CloseCol();
				$Output[$Rep2['Jour']]->CloseRow();
				$Assistant[$Rep2['Jour']] = TRUE;
			}
			$Hr = intval($Rep2['Start']/3600);
			$Min = intval(bcmod($Rep2['Start'],3600)/60);
			$Start = array('G'=>$Hr,'i'=>$Min);
			$Hr = intval($Rep2['End']/3600);
			$Min = intval(bcmod($Rep2['End'],3600)/60);
			$End = array('G'=>$Hr,'i'=>$Min);
			if($Start['i']==0)
				$Start['i']="";
			if($End['i']==0)
				$End['i']="";
			$Output[$Rep2['Jour']]->openrow();
			$Output[$Rep2['Jour']]->opencol();
			$Output[$Rep2['Jour']]->addtexte($Start['G']."h".$Start['i']."&nbsp;�&nbsp;".$End['G']."h".$End['i'], 'Titre2');
			if(!$_GET['ToPrint'])
				$Output[$Rep2['Jour']]->AddLink('index.php?Section=Shift_Form&IDShift='.$Rep2['IDShift'], '<img src=assets/buttons/b_edit.png border=0>');
			$Output[$Rep2['Jour']]->closecol();
			$Output[$Rep2['Jour']]->closerow();
			$Output[$Rep2['Jour']]->openrow();
			$Diplay="";
				$Class = "Safe";
			$Output[$Rep2['Jour']]->opencol('','1','top',$Class);
			$Diplay="";
			if($Rep2['HName']=="")
				$Display = substr($Rep2['Prenom']."&nbsp;".$Rep2['Nom'],0,20);
			else
				$Display = $Rep2['HName'];
			if($Rep2['IDEmploye']==0)
				$Output[$Rep2['Jour']]->addtexte('&nbsp;');
			else
			$Output[$Rep2['Jour']]->addlink('index.php?Section=Employe&IDEmploye='.$Rep2['IDEmploye'],$Display);
			$Output[$Rep2['Jour']]->closecol();
			$Output[$Rep2['Jour']]->closerow();
			$Output[$Rep2['Jour']]->openrow();
			$Output[$Rep2['Jour']]->opencol();
			$Output[$Rep2['Jour']]->addtexte(" ");
			$Output[$Rep2['Jour']]->closecol();
			$Output[$Rep2['Jour']]->closerow();
		}
		for($d=0;$d<=6;$d++){
			$MainOutput->opencol('10.0%','1','top','HDay');
			$MainOutput->OpenTable();
			$MainOutput->openrow();
			$MainOutput->opencol();
			$MainOutput->addtexte('<div align=center>'.$CJour[$d]." ".$MDay[$d].'</div>');
			$MainOutput->closecol();
			$MainOutput->closerow();
			$MainOutput->AddOutput($Output[$d]->Send(),0,0);
			$MainOutput->CloseTable();
			$MainOutput->CloseCol();
		}
		$MainOutput->closeRow();
	}
	$MainOutput->CloseTable();
}
echo $MainOutput->send(1);
?>	

