<?PHP
$MainOutput->OpenTable();
if(!isset($_GET['ToPrint']))
	$_GET['ToPrint']=False;
$SQL2 = new sqlclass();
$SemD = get_date($_GET['Semaine']);
$CurrentDay = $_GET['Semaine'];
$i=0;
while($i<=5){
 $CurrentDay+= get_day_length($CurrentDay);
	$i++;
}
$SemE = get_date($CurrentDay);
$Month = get_month_list('court');
$Time = $SemD;
$Time2 = $SemE;
$Month = get_month_list('court');

if(isset($Rapport)){
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',8);
		$MainOutput->AddOutput($Rapport->Send(1),0,0);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	}


$MainOutput->OpenRow();
$MainOutput->OpenCol(900,8);
if(!$_GET['ToPrint']){
	$MainOutput->addlink('index.php?Section=Add_Remplacement&Semaine='.$_GET['Semaine'],'<img border=0 src=b_ins.png>');
	$MainOutput->addlink('index.php?Section=Display_Shit&Semaine='.$_GET['Semaine'].'&ToPrint=TRUE','<img border=0 src=b_print.png>','_BLANK');
}
$MainOutput->addtexte('<div align=Center>Feuille de temps de la semaine du '.$Time['d']."-".$Month[intval($Time['m'])]."-".$Time['Y']." au ".$Time2['d']."-".$Month[intval($Time2['m'])]."-".$Time2['Y'].'</div>','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
if(!$_GET['ToPrint']){
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('450',1);
	$MainOutput->addoutput('<div align=right>',0,0);
	$MainOutput->AddLink('index.php?Section=Display_Shit&Semaine='.get_last_sunday(2,$_GET['Semaine']),'<<');
	$MainOutput->addoutput('</div>',0,0);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('450',3);
	$MainOutput->addoutput('<div align=left>',0,0);
	$MainOutput->AddLink('index.php?Section=Display_Shit&Semaine='.get_last_sunday(1,$_GET['Semaine']),'Semaine Précédente');
	$MainOutput->addoutput('</div>',0,0);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('450',3);
	$MainOutput->addoutput('<div align=right>',0,0);
	$MainOutput->AddLink('index.php?Section=Display_Shit&Semaine='.get_next_sunday(0,$_GET['Semaine']),'Semaine Suivante');
	$MainOutput->addoutput('</div>',0,0);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('450',1);
	$MainOutput->addoutput('<div align=left>',0,0);
	$MainOutput->AddLink('index.php?Section=Display_Shit&Semaine='.get_next_sunday(1,$_GET['Semaine']),'>>');
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
$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');

$CurrentDate = $_GET['Semaine'];
$current_semaine = $_GET['Semaine'];
for($d=0;$d<=6;$d++){
	$MainOutput->opencol(115);
	$MainOutput->addtexte("<a href='index.php?Section=generate_free_employees&Semaine={$current_semaine}&Day={$d}' target='_blank'><div align=center>".$CJour[$d]."</div>", 'Titre');
	$Date = get_date($CurrentDate);
	$CurrentDate += get_day_length($CurrentDate);
	$MainOutput->addtexte("<div align=center>".$Date['d']."-".$Month[intval($Date['m'])]."</div></a>", 'Titre');
	$MDay[$d] = $Date['d']."-".$Month[intval($Date['m'])];
	$MainOutput->closecol();
}
$MainOutput->CloseRow();
$Req2 = "SELECT DISTINCT shift.IDInstallation, installation.`Nom`, installation.Cote, installation.Tel FROM shift JOIN installation on installation.IDInstallation = shift.IDInstallation WHERE Semaine = '".$_GET['Semaine']."'  AND (IDEmploye=0 OR Warn<>'') ORDER BY installation.IDClient ASC, installation.Nom ASC";	
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
	
	$Req3 = "SELECT IDShift, Jour, Start, End, Warn, Confirme, Assistant, shift.IDEmploye, Nom, Prenom, HName FROM shift LEFT JOIN employe on shift.IDEmploye = employe.IDEmploye WHERE IDInstallation=".$Rep[0]." AND Semaine=".$_GET['Semaine']." AND (shift.IDEmploye=0 OR Warn<>'') ORDER BY Jour ASC, Assistant ASC, Start ASC";
	$SQL2->SELECT($Req3);
	$Output = array(0=>new HTML,1=>new HTML,2=>new HTML,3=>new HTML,4=>new HTML,5=>new HTML,6=>new HTML);
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
		$Output[$Rep2['Jour']]->addtexte($Start['G']."h".$Start['i']."&nbsp;à&nbsp;".$End['G']."h".$End['i'], 'Titre2');
		if(!$_GET['ToPrint'])
			$Output[$Rep2['Jour']]->AddLink('index.php?Section=Shift_Form&IDShift='.$Rep2['IDShift'],'<img src=b_edit.png border=0>');
		$Output[$Rep2['Jour']]->closecol();
		$Output[$Rep2['Jour']]->closerow();
		$Output[$Rep2['Jour']]->openrow();
		$Diplay="";
		if($Rep2['IDEmploye']==0)
			$Class = "ToRempl";
		else
			$Class = "Warn";
			
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
$MainOutput->Closetable();

echo $MainOutput->send(1);
?>
