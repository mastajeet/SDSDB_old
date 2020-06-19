<?PHP
$MainOutput->OpenTable();
if(!isset($_GET['ToPrint']))
	$_GET['ToPrint']=False;
$SQL2 = new sqlclass();
if(!isset($_GET['Semaine']))
	$_GET['Semaine']=get_last_sunday();
	
$SemD = get_date($_GET['Semaine']);
$SemE = get_date($_GET['Semaine'] + 6*(86400));
$Month = get_month_list('court');
$Time = $SemD;
$Time2 = $SemE;
$Month = get_month_list('court');

$MainOutput->OpenRow();
$MainOutput->OpenCol(900,8);

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
	$MainOutput->AddLink('index.php?Section=Display_Shift&Semaine='.get_last_sunday(1,$_GET['Semaine']),'Semaine pr�c�dente');
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
$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
for($d=0;$d<=6;$d++){
	$MainOutput->opencol(115);
	$MainOutput->addtexte("<div align=center>".$CJour[$d]."</div>", 'Titre');
	$Date = get_date($_GET['Semaine']+$d*86400);
	$MainOutput->addtexte("<div align=center>".$Date['d']."-".$Month[intval($Date['m'])]."</div>", 'Titre');
	$MDay[$d] = $Date['d']."-".$Month[intval($Date['m'])];
	$MainOutput->closecol();
}
$MainOutput->CloseRow();
$Req2 = "SELECT DISTINCT shift.IDInstallation, installation.`Nom`, installation.Cote, installation.Tel FROM shift JOIN installation on installation.IDInstallation = shift.IDInstallation WHERE Semaine = '".$_GET['Semaine']."' and installation.IDClient=".$_COOKIE['IDClient']." ORDER BY installation.IDClient ASC, installation.Nom ASC";	
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
	
	$Req3 = "SELECT IDShift, Jour, Start, End, Warn, Commentaire, Confirme, shift.IDEmploye, Nom, Prenom, HName, Assistant FROM shift LEFT JOIN employe on shift.IDEmploye = employe.IDEmploye WHERE IDInstallation=".$Rep[0]." AND Semaine=".$_GET['Semaine']." ORDER BY Jour ASC, Assistant ASC, Start ASC";
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
		$Output[$Rep2['Jour']]->closecol();
		$Output[$Rep2['Jour']]->closerow();
		$Output[$Rep2['Jour']]->openrow();
		
		$Class = "safe";
		
		if(($Rep2['Commentaire']<>"" || $Rep2['Warn']<>"") AND $_GET['Semaine'] >= get_last_sunday())
			$Class = "warn";
		
		if($Rep2['IDEmploye']=="0")
			$Class = "rempl";
		
		if($Rep2['Confirme']==0 && $_GET['Semaine'] < get_last_sunday() )
			$Class = "unconfirmed";
		
		$Output[$Rep2['Jour']]->opencol('','1','top',$Class);
			$Display = substr($Rep2['Prenom']."&nbsp;".$Rep2['Nom'],0,20);
	

		if($Rep2['IDEmploye']=="0")
			$Output[$Rep2['Jour']]->addtexte('&nbsp;');
		else
			$Output[$Rep2['Jour']]->addlink('index.php?Section=Ajouter_Commentaire&IDShift='.$Rep2['IDShift'],$Display);
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
