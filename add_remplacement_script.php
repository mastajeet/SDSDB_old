<?PHP
//Premiï¿½rement Enlever de l'horaire la personne
$InfoEmpl = get_employe_info($_POST['FORMIDEmployeS']);
$InfoEmpl2 = get_employe_info($_POST['FORMTalkedto']);
$Rapport = new HTML;

$RapportEmail = "<html><body>";
$AUCUN = FALSE;
if(!isset($_POST['FORMEmail']))
	$_POST['FORMEmail']=FALSE;

	$Rapport->OpenTable(300);
	$Rapport->OpenRow();
	$Rapport->OpenCol(300,3);
	$Rapport->AddTexte('Remplacements ajoutés à la liste','Titre');
	$Rapport->CloseCol();
	$Rapport->CloseRow();
	$RapportEmail .= "<table witdth=450 cellspacing=0 cellpadding=0><tr><td colspan=3 width=450><font face=tahoma size=2><b>Bonjour ".$InfoEmpl['Prenom']." (#".$_POST['FORMIDEmployeS']."), voici les remplacements que tu as demandï¿½s</b></font><br>
	<br></td></tr>";
	
if($_POST['FORMFROM5']<>"" AND $_POST['FORMIDEmployeS']<>""){

$SQL = new sqlclass;
$SQL2 = new sqlclass;


if(!isset($_POST['FORMLastminute']))
	$_POST['FORMLastminute']="0";
	$THDate = mktime(0,0,0,$_POST['FORMFROM4'],$_POST['FORMFROM5'],$_POST['FORMFROM3']);
        
	$FROM = get_last_sunday(0,$THDate)+intval(date('w',$THDate))*60*60*24;
        
        if($_POST['FORMTO5']=="")
		$TO = $FROM;
	else{
        $THDate = mktime(0,0,0,$_POST['FORMTO4'],$_POST['FORMTO5'],$_POST['FORMTO3']);
        
            $TO = get_last_sunday(0,$THDate)+intval(date('w',$THDate))*60*60*24;
            
        }




    $Req = "INSERT INTO `vacances` (`IDEmploye`, `DebutVacances`, `FinVacances`, `Raison`) VALUES (".$_POST['FORMIDEmployeS'].",".$FROM.",".$TO.",'".addslashes($_POST['FORMRaison'])."')";
       $SQL->SELECT($Req);
    $Req = "SELECT
	shift.IDShift,shift.Semaine + shift.Jour*60*60*24 as T, installation.Nom, shift.Start, shift.End 
	FROM shift JOIN installation on shift.IDInstallation = installation.IDInstallation
	WHERE IDEmploye = ".$_POST['FORMIDEmployeS']." AND Semaine + Jour*60*60*24 >= ".$FROM." AND Semaine + Jour*60*60*24 <= ".$TO."
	ORDER BY Semaine+Jour*60*60*24+Start ASC";
    $SQL->SELECT($Req);

    if($SQL->NumRow()==0){
	$Rapport->OpenRow();
	$Rapport->OpenCol(300,3);
	$Rapport->AddTexte('Aucun');
	$Rapport->CloseCol();
	$Rapport->CloseRow();
$AUCUN = TRUE;
};

	$Month = get_month_list('long');
	
	$Today = time();
	$IDShifts="";
	
	while($Rep = $SQL->FetchArray()){
		
	$Req2 = "INSERT INTO remplacement(`IDEmployeS`,`IDShift`,`Raison`,`Talkedto`,`Asked`,`Lastminute`) 
	VALUES(
	".$_POST['FORMIDEmployeS'].",
	".$Rep['IDShift'].",
	'".addslashes($_POST['FORMRaison'])."',
	'".$_POST['FORMTalkedto']."',
	".$Today.",
	".$_POST['FORMLastminute'].")";
	$SQL2->INSERT($Req2);



	$IDShifts .= $Rep['IDShift'].",";
	
		
	$Date = get_date($Rep['T']);
	$Start= get_date($Rep['Start']);
	$End = get_date($Rep['End']);
	if($Start['i']==0)
		$Start['i']="";
	if($End['i']==0)
		$End['i']="";

	$Rapport->OpenRow();
	
	$Rapport->OpenCol();
	$Rapport->addtexte($Date['d']."-".$Month[intval($Date['m'])]."-".$Date['Y'],'Titre');
	$Rapport->CloseCol();
	
	$Rapport->OpenCol();
	$Rapport->addtexte($Rep['Nom']);
	$Rapport->CloseCol();


	$Rapport->OpenCol();
	$Rapport->addtexte($Start['G']."h".$Start['i']." ï¿½ ".$End['G']."h".$End['i']);
	$Rapport->CloseCol();
	
	$Rapport->CloseRow();
	
	$RapportEmail .= "<tr><td width=150><font face=tahoma size=2><b>".$Date['d']."-".$Month[intval($Date['m'])]."-".$Date['Y']."</b></font></td>";
	$RapportEmail .= "<td width=150><font face=tahoma size=2>".$Rep['Nom']."</font></td>";
	$RapportEmail .= "<td width=150><font face=tahoma size=2>".$Start['G']."h".$Start['i']." ï¿½ ".$End['G']."h".$End['i']."</font></td></tr>";
	
	}

	$IDShifts = substr($IDShifts,0,-1);
	$Infoemp = get_employe_info($_POST['FORMIDEmployeS']);
	$Req3 = "UPDATE shift SET IDEmploye=0, Commentaire='".addslashes($Infoemp['Prenom'])." ".addslashes($Infoemp['Nom']).": ".addslashes($_POST['FORMRaison'])."'  WHERE IDShift in (".$IDShifts.")";
if($SQL->NumRow()<>0)
	$SQL2->QUERY($Req3);
	
}else{
		$Rapport->OpenRow();
		$Rapport->OpenCol('100%',3);
		$Rapport->AddTexte('Il manque quelques donnï¿½es','Warning');
		$Rapport->CloseCol();
		$Rapport->CloseRow();
		$AUCUN=TRUE;
	}
$Rapport->CloseTable();
$Time = get_date(time());
$RapportEmail .= "<tr><td width=450 colspan=3><br><font face=tahoma size=2><b>Raison:</b> ".$_POST['FORMRaison']."</font></td></tr>";
$RapportEmail .= "<tr><td width=450 colspan=3><font face=tahoma size=2><b>Demandï¿½:</b> ".$InfoEmpl2['Prenom']." ".$InfoEmpl2['Nom']."</font></td></tr>";
$RapportEmail .= "<tr><td width=450 colspan=3><font face=tahoma size=2><b>Demandï¿½ le:</b> ".$Time['d']."-".$Month[intval($Time['m'])]."-".$Time['Y']."</font></td></tr>";
$RapportEmail .= "<tr><td width=450 colspan=3><font face=tahoma size=2><b>Pour tous problï¿½mes, appelle nous au (418) 687-4047</font></b></td></tr></table>";
//Possibilitïé d'envoyer un email
if(!$AUCUN AND $_POST['FORMEmail'])
	send_mail($InfoEmpl['Email'],"Demande de remplacement reçue",$RapportEmail,TRUE);
?>