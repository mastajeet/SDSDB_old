<?PHP
function get_employe_horaire($IDEmploye,$Semaine){
	$SQL = new sqlclass;
	$SQL2  = new sqlclass;
	$MainOutput = new HTML;
	
	if(!is_array($Semaine)){
		$Semaine = array($Semaine);
	}
	echo "<!-- généré le ".date("d-m-Y",time())."--!>";
    
	$MainOutput->OpenTable(700);
	$Month = get_month_list('court');
	foreach($Semaine as $v){
	$MainOutput->OpenRow();
		$DayOffset=0;
	
		for($d=0;$d<=6;$d++){
			$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
			$MainOutput->opencol(115);
			$MainOutput->addtexte("<div align=center>".$CJour[$d]."</div>", 'Titre');
			$Date = get_date($v+$DayOffset);
			
			$MainOutput->addtexte("<div align=center>".$Date['d']."-".$Month[intval($Date['m'])]."</div>", 'Titre');
			$MDay[$d] = $Date['d']."-".$Month[intval($Date['m'])];
			$DayOffset += get_day_length($v + $DayOffset);
			$MainOutput->closecol();
		}
	$MainOutput->CloseRow();
	$MainOutput->OpenRow();
		for($d=0;$d<=6;$d++){
			$IDInstallation="";
			$Req = "SELECT shift.IDShift, Jour, IDInstallation, Start, End, Warn FROM shift LEFT JOIN remplacement on shift.IDShift = remplacement.IDShift WHERE (IDEmploye = ".$IDEmploye."  OR IDEmployeS = ".$IDEmploye.") AND Semaine = ".$v." AND Jour=".$d." ORDER BY Jour ASC, `Start` ASC";
			$SQL->SELECT($Req);
			$MainOutput->opencol(115,1,'top','Square');
			while($Rep = $SQL->FetchArray()){
				if($IDInstallation <> $Rep['IDInstallation']){
					$InfoIns = get_installation_info($Rep['IDInstallation']);
					$MainOutput->Addlink($InfoIns['Lien'],$InfoIns['Nom'],'_BLANK','Titre');
					$IDInstallation = $Rep['IDInstallation'];
					$MainOutput->br();
				}else{
				$MainOutput->br();
				}


			$Start= get_date($Rep['Start']);
			$End = get_date($Rep['End']);
					if($Start['i']==0)
						$Start['i']="";
					if($End['i']==0)
						$End['i']="";

			$Req2 = "SELECT IDEmployeE, Prenom, Nom, IDEmployeS FROM remplacement LEFT JOIN employe on IDEmployeE = IDEmploye WHERE IDShift = ".$Rep['IDShift'];
			$SQL2->SELECT($Req2);

			if($Rep['Warn']<>"")
					$MainOutput->addtexte($Start['G']."h".$Start['i']."&nbsp;à&nbsp;".$End['G']."h".$End['i'], 'unconfirmed');
		else{
			
			if($SQL2->NumRow()==0)
					$MainOutput->addtexte($Start['G']."h".$Start['i']."&nbsp;à&nbsp;".$End['G']."h".$End['i'], 'ok');
	
			else{
				$Rep2 = $SQL2->FetchArray();
				if($Rep2[0]==0)
						$MainOutput->addtexte($Start['G']."h".$Start['i']."&nbsp;à&nbsp;".$End['G']."h".$End['i'], 'torempl');
				else{
					if($Rep2[0]==$IDEmploye)
						$MainOutput->addtexte($Start['G']."h".$Start['i']."&nbsp;à&nbsp;".$End['G']."h".$End['i'], 'ok');
					else
						$MainOutput->addtexte($Rep2[1]." ".$Rep2[2]);
				}
			}
		}
				$MainOutput->br();
			}
				$MainOutput->closecol();
		}
		$MainOutput->CloseRow();
	}
	$MainOutput->CloseTable();
	return $MainOutput->Send(1);
}

function get_employe_horaire_email($IDEmploye,$Semaine){
	$SQL = new sqlclass;
	$SQL2  = new sqlclass;
	$MainOutput = new HTML;
	
	if(!is_array($Semaine)){
		$Semaine = array($Semaine);
	}
	
	$MainOutput->OpenTable(700);
	$Month = get_month_list('court');
	foreach($Semaine as $v){
	$MainOutput->OpenRow();
	
		for($d=0;$d<=6;$d++){
			$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
			$MainOutput->addoutput("<td width=115><div align=center><font face=tahoma size=2><b>".$CJour[$d]."</div>",0,0);
			$Date = get_date($v+$d*86400);
			$MainOutput->addoutput("<div align=center>".$Date['d']."-".$Month[intval($Date['m'])]."</b></font></div>",0,0);
			$MDay[$d] = $Date['d']."-".$Month[intval($Date['m'])];
			$MainOutput->addoutput("</td>",0,0);
		}
	$MainOutput->CloseRow();
	$MainOutput->OpenRow();
		for($d=0;$d<=6;$d++){
			$IDInstallation="";
			$Req = "SELECT shift.IDShift, Jour, IDInstallation, Start, End, Warn FROM shift LEFT JOIN remplacement on shift.IDShift = remplacement.IDShift WHERE (IDEmploye = ".$IDEmploye."  OR IDEmployeS = ".$IDEmploye.") AND Semaine = ".$v." AND Jour=".$d." ORDER BY Jour ASC, `Start` ASC";
			$SQL->SELECT($Req);
			$MainOutput->addoutput('<td width=115 valign=Top Style="border-bottom-width: 1;
	border-left-width: 1;
	border-right-width: 1;
	border-top-width: 1;
	border-style: solid;">',0,0);
			while($Rep = $SQL->FetchArray()){
				if($IDInstallation <> $Rep['IDInstallation']){
					$InfoIns = get_installation_info($Rep['IDInstallation']);
					$MainOutput->AddOutput("<a href=".$InfoIns['Lien']." target=_BLANK><b><font face=tahoma size=2 color=Black>".str_replace(" ", "&nbsp;", $InfoIns['Nom'])."</b></a></font><br \>",0,0);
					$IDInstallation = $Rep['IDInstallation'];
			
				}else{
				$MainOutput->br();
				}


			$Start= get_date($Rep['Start']);
			$End = get_date($Rep['End']);
					if($Start['i']==0)
						$Start['i']="";
					if($End['i']==0)
						$End['i']="";

			$Req2 = "SELECT IDEmployeE, Prenom, Nom, IDEmployeS FROM remplacement LEFT JOIN employe on IDEmployeE = IDEmploye WHERE IDShift = ".$Rep['IDShift'];
			$SQL2->SELECT($Req2);

			if($Rep['Warn']<>"")
					$MainOutput->AddOutput("<font face=tahoma size=2 style='background-color: #FFD71C;'>".$Start['G']."h".$Start['i']."&nbsp;à&nbsp;".$End['G']."h".$End['i']."<font>",0,0);
		else{
			
			if($SQL2->NumRow()==0)
					$MainOutput->AddOutput("<font face=tahoma size=2 style='background-color: #0CFF00;'>".$Start['G']."h".$Start['i']."&nbsp;à&nbsp;".$End['G']."h".$End['i']."<font>",0,0);
	
			else{
				$Rep2 = $SQL2->FetchArray();
				if($Rep2[0]==0)
						$MainOutput->AddOutput("<font face=tahoma size=2 style='background-color: #FF72A4'>".$Start['G']."h".$Start['i']."&nbsp;à&nbsp;".$End['G']."h".$End['i']."<font>",0,0);
				else{
					if($Rep2[0]==$IDEmploye)
						$MainOutput->AddOutput("<font face=tahoma size=2 style='background-color: #0CFF00;'>".$Start['G']."h".$Start['i']."&nbsp;à&nbsp;".$End['G']."h".$End['i']."<font>",0,0);
					else
						$MainOutput->AddOutput("<font face=tahoma size=2 style='background-color: #0CFF00;'>".$Rep2[1]." ".$Rep2[2]."<font>",0,0);
				}
			}
		}
				$MainOutput->br();
			}
				$MainOutput->closecol();
		}
		$MainOutput->CloseRow();
	}
	$MainOutput->CloseTable();
	return $MainOutput->Send(1);
}


function get_employe_horshift($IDEmploye,$ALL=FALSE){
	$SQL = new sqlclass;
	$SQL2  = new sqlclass;
	$MainOutput = new HTML;
	

	$MainOutput->OpenTable(700);
	$Month = get_month_list('court');

	$MainOutput->OpenRow();
	
		for($d=0;$d<=6;$d++){
			$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
			$MainOutput->opencol(115);
			$MainOutput->addtexte("<div align=center>".$CJour[$d]."</div>", 'Titre');
			$MainOutput->closecol();
		}

		$MainOutput->CloseRow();
		$MainOutput->OpenRow();
		for($d=0;$d<=6;$d++){
			$IDInstallation="";
			if(!$ALL)
				$Req = "SELECT horshift.IDHorshift, Jour, IDInstallation, `Start`, `End` FROM horshift JOIN installation ON horshift.IDHoraire = installation.IDHoraire WHERE Confirm AND IDEmploye = ".$IDEmploye." AND Jour=".$d." AND Saison ORDER BY Jour ASC, `Start` ASC";
			else
				$Req = "SELECT horshift.IDHorshift, Jour, IDInstallation, `Start`, `End` FROM horshift JOIN installation ON horshift.IDHoraire = installation.IDHoraire WHERE IDEmploye = ".$IDEmploye." AND Jour=".$d." AND Saison ORDER BY Jour ASC, `Start` ASC";
			$SQL->SELECT($Req);
			$MainOutput->opencol(115,1,'top','Square');
			while($Rep = $SQL->FetchArray()){
				if($IDInstallation <> $Rep['IDInstallation']){
					$InfoIns = get_installation_info($Rep['IDInstallation']);
					$MainOutput->Addlink($InfoIns['Lien'],$InfoIns['Nom'],'_BLANK','Titre');
					$IDInstallation = $Rep['IDInstallation'];
					$MainOutput->br();
				}else{
				$MainOutput->br();
				}


			$Start= get_date($Rep['Start']);
			$End = get_date($Rep['End']);
					if($Start['i']==0)
						$Start['i']="";
					if($End['i']==0)
						$End['i']="";

				$MainOutput->addtexte($Start['G']."h".$Start['i']."&nbsp;à&nbsp;".$End['G']."h".$End['i'], 'ok');
				$MainOutput->br();
			}
				$MainOutput->closecol();
			
		}
		$MainOutput->CloseRow();

	$MainOutput->CloseTable();
	return $MainOutput->Send(1);
}

function update_lastvisited($IDEmploye,$Time){
	$SQL = new sqlclass;
	$Req = "UPDATE employe SET LastVisited =".$Time." WHERE IDEmploye = ".$IDEmploye;
	$SQL->query($Req);
	return TRUE;
}

function get_lastvisited($IDEmploye){
	$SQL = new sqlclass;
	$Req = "SELECT LastVisited FROM employe WHERE IDEmploye = ".$IDEmploye;
	$SQL->select($Req);
	$Temp = $SQL->FetchArray();
	return getdate($Temp['LastVisited']);
}


function get_employe_info($IDEmploye){
	$SQL = new sqlclass;
	$Req = "SELECT * FROM employe WHERE IDEmploye='$IDEmploye'";
	$SQL->SELECT($Req);
	return $SQL->FetchArray();
}

function get_employe_ferie($IDEmploye,$Time){
	$SQL = new sqlclass;
	$End = get_last_sunday(1,$Time);
	$Mid2 = get_last_sunday(2,$Time);
	$Mid = get_last_sunday(3,$Time);
	$Start = get_last_sunday(4,$Time);
	$Req = "SELECT IDPaye, Semaine1, Semaine2 FROM paye WHERE Semaine1 = ".$Start." OR Semaine2 = ".$Start;
	$SQL->Select($Req);
	$Rep = $SQL->FetchArray();
	$IDPaye = $Rep['IDPaye'];
if($Rep['Semaine1']==$Start){
		$Req2 = "SELECT sum((S10+S11+S12+S13+S14+S15+S16+S20+S21+S22+S23+S24+S25+S26+Ajustement)*Salaire) FROM timesheet where IDEmploye=".$IDEmploye." AND Heures and IDPaye=".$IDPaye." AND timesheet.IDEmploye=".$IDEmploye." GROUP BY IDEmploye";
		$SQL->SELECT($Req2);
		$Rep = $SQL->FetchArray();
		$Sum = $Rep[0];
		$Req3 = "SELECT sum((S10+S11+S12+S13+S14+S15+S16+S20+S21+S22+S23+S24+S25+S26+Ajustement)*Salaire) FROM timesheet JOIN paye on timesheet.IDPaye = paye.IDPaye WHERE paye.Semaine2 = ".$End." AND timesheet.IDEmploye=".$IDEmploye." AND Heures GROUP BY IDEmploye";
		$SQL->SELECT($Req3);
		$Rep = $SQL->FetchArray();		
		$Sum = $Sum+$Rep[0];
return round($Sum/20,2);
	}else{
		$Req2 = "SELECT sum((S20+S21+S22+S23+S24+S25+S26+Ajustement/2)*Salaire) FROM timesheet where IDEmploye=".$IDEmploye." and IDPaye=".$IDPaye." AND timesheet.IDEmploye=".$IDEmploye." AND Heures GROUP BY IDEmploye";
		$SQL->SELECT($Req2);
		$Rep2 = $SQL->FetchArray();
		$Sum = $Rep2[0];
		$Req3 = "SELECT sum((S10+S11+S12+S13+S14+S15+S16+S20+S21+S22+S23+S24+S25+S26+Ajustement)*Salaire) FROM timesheet JOIN paye on timesheet.IDPaye = paye.IDPaye WHERE paye.Semaine1 = ".$Mid." AND timesheet.IDEmploye=".$IDEmploye." AND Heures GROUP BY IDEmploye";
		$SQL->SELECT($Req3);
		$Rep2 = $SQL->FetchArray();
		$Sum = $Sum+$Rep2[0];
		$Req3 = "SELECT sum((S10+S11+S12+S13+S14+S15+S16+Ajustement/2)*Salaire) FROM timesheet JOIN paye on timesheet.IDPaye = paye.IDPaye WHERE paye.Semaine1 = ".$End." AND timesheet.IDEmploye=".$IDEmploye."  AND Heures GROUP BY IDEmploye";
		$SQL->SELECT($Req3);
		$Rep2 = $SQL->FetchArray();
		$Sum = $Sum+$Rep2[0];
		return round($Sum/20,2);
	}
}


function get_qualif_employe($IDEmploye){
	$SQL = new sqlclass;
	$SQL2 = new sqlclass;
	$Req = "SELECT IDQualification FROM qualification ORDER BY IDQualification ASC";
	$SQL->SELECT($Req);
	$Ret = array();
	while($Rep = $SQL->FetchArray()){
		$Req2 = "SELECT Expiration FROM link_employe_qualification WHERE IDEmploye = ".$IDEmploye." AND IDQualification = ".$Rep[0];
		$SQL2->SELECT($Req2);
		$Rep2 = $SQL2->FetchArray();
		if($SQL2->NumRow()==0)
			$Ret[$Rep[0]] = 0;
		else
			$Ret[$Rep[0]] = $Rep2[0];
	}
	return $Ret;
}

function get_employe_working($IDPaye){
	$SQL = new sqlclass;
	$Req = "SELECT DISTINCT employe.IDEmploye, Nom, Prenom FROM employe RIGHT JOIN timesheet ON employe.IDEmploye = timesheet.IDEmploye WHERE IDPaye = ".$IDPaye." ORDER BY IDEmploye ASC";
	$SQL->SELECT($Req);
	$Ret = array();
	while($Rep = $SQL->FetchArray()){
		$Ret[$Rep[0]] = array('Nom'=>$Rep[1],'Prenom'=>$Rep[2]);
	}
	return $Ret;
}

function get_message_info($IDMessage){
	$SQL = new sqlclass;
	$Req = "SELECT * FROM message WHERE IDMessage = ".$IDMessage;
	$SQL->SELECT($Req);
	return $SQL->FetchArray();
}

function get_messages(){
	$SQL = new sqlclass;
	$Now = time();
	$Req = "SELECT * FROM message WHERE Start<=".$Now." AND End+24*60*60>=".$Now." ORDER BY IDMessage DESC"; 
	$SQL->SELECT($Req);
	$Ret = array();
	while($Rep = $SQL->FetchArray()){
		$Ret[$Rep['IDMessage']] = array('Titre'=>$Rep['Titre'],'Texte'=>$Rep['Texte'],'Start'=>$Rep['Start'],'IDEmploye'=>$Rep['IDEmploye']);
	}
	return $Ret;
}

function get_employe_initials($IDEmploye){
    $Info = get_employe_info($IDEmploye);
    $Initiales = "";


    foreach(explode('-',$Info['Prenom']) as $v){
        $Initiales .= substr($v,0,1);

    }

    foreach(explode('-',$Info['Nom']) as $v){
        $Initiales .= substr($v,0,1);

    }

    return $Initiales;
}



?>