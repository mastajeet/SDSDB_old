<?PHP

//Vérification si le bureau des heure est ouvert
// Ven 17 -> Lun 9h
$Now = time();
$Week = get_last_sunday();
$Shift = $Now - $Week;
$ToConfirm = 0;
$SQL = new sqlclass();
$SQL2 = new sqlclass();
$SQL3 = new sqlclass();
if($Shift<=126000)
	$ToConfirm = get_last_sunday(1);
else
	$ToConfirm = get_last_sunday();
//elseif($Shift>=493200)
//	$ToConfirm = get_last_sunday();
$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
$Time = time();
$Today = date('w',$Time);
if($Week<>$ToConfirm)
	$Today=8;
$RN = intval($Today*24*60*60)+intval(date('H',$Time))*60*60+intval(date('i',$Time)*60);

$employe = new Employee($_COOKIE['IDEmploye']);


$Req = "SELECT IDConfirmation, Notes FROM confirmation WHERE IDEmploye= ".$_COOKIE['IDEmploye']." AND Semaine=".$ToConfirm;
$SQL->SELECT($Req);
$NB = $SQL->NumRow();
$Notes = "";
while($Rep2 = $SQL->FetchArray())
	$Notes = $Rep2['Notes'];
if(isset($IDConfirmation)){
	$MainOutput->AddTexte('Heures confirmées','Warning');
	$MainOutput->br();
}
$MainOutput->AddTexte('Confirmation d\'heures','Titre');
$MainOutput->br();
$MainOutput->AddTexte('Veuillez entrer les heures travaillées ainsi que les notes pertinentes de la semaine.');
$MainOutput->br();
$MainOutput->AddTexte('Notez qu\'il faut <b>ABSOLUMENT</b> cliquer sur le bouton CONFIRMER (qui est a droite complètement) afin que vos heures soient envoyées');
$MainOutput->br(2);
$MainOutput->opentable('100%');
$MainOutput->addoutput('<form action=index.php method=POST>',0,0);
$MainOutput->inputhidden_env('Action','Confirm_Heures');
$MainOutput->inputhidden_env('Semaine',$ToConfirm);
$MainOutput->inputhidden_env('IDEmploye',$_COOKIE['IDEmploye']);
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
$MainOutput->OpenRow('');
$MainOutput->OpenCol('',8);
$ToConfirmDates = get_end_dates(0,$ToConfirm);
$MainOutput->AddTexte("Heure à confirmer: ".$employe->getHoraireName().' pour la semaine du '.$ToConfirmDates['Start'].' au '.$ToConfirmDates['End'],'Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->OpenRow('');
$Sum=0;
foreach($CJour as $k=>$v){
	if($Today>=$k){
		$Installation ="";
		$Req2 = "SELECT Start, End, Nom, IDShift FROM shift JOIN installation ON shift.IDInstallation = installation.IDInstallation WHERE Semaine='".$ToConfirm."' && EmpConf='0' && IDEmploye='".$_COOKIE['IDEmploye']."' && Jour='".$k."' && !Confirme && Jour*3600*24+End<=".$RN."  ORDER BY Start ASC";
		$SQL2->Select($Req2);
		$MainOutput->OpenCol(50);
		$MainOutput->OpenTable();
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('',3);
		$MainOutput->Addtexte($v,'Titre');
		$MainOutput->CloseCol();
		if($SQL2->NumRow()==0){
			$Req2 = "SELECT Start, End, Nom, IDShift, Confirme, EmpConf, Jour FROM shift JOIN installation ON shift.IDInstallation = installation.IDInstallation WHERE Semaine='".$ToConfirm."' && IDEmploye='".$_COOKIE['IDEmploye']."' && Jour='".$k."'  ORDER BY Start ASC";
			$SQL3->SELECT($Req2);
			$Rep3 = $SQL3->FetchArray();
			if($SQL3->NumRow()==0){
				$TXT = " ";
			}elseif($Rep3['EmpConf']){
				$TXT = "Shift Confirmé";
			}elseif($Rep3['Confirme']){
				$TXT = "Shift Confirmé";
			}elseif($Rep3['Jour']<$Today){
				$TXT = " ";
			}elseif($Rep3['Jour']==$Today AND $Rep3['Jour']*2400*60+$Rep3['End']>=$RN){
				$TXT = "Shift non completé";
			}
			$MainOutput->OpenRow();
			$MainOutput->OpenCol();
			$MainOutput->addtexte($TXT,'Warning');
			$MainOutput->CloseCol();
			$MainOutput->CloseRow();
		}
				
		
		while($Rep2 = $SQL2->FetchArray()){
			if($Installation <> $Rep2[2]){
				$Installation = $Rep2[2];
				$MainOutput->OpenRow();
				$MainOutput->OpenCol('',3);
				$MainOutput->Addtexte($Installation,'Titre');
				$MainOutput->CloseCol();
				$MainOutput->CloseRow();
			}
			$MainOutput->OpenRow();
			$Sh = $Rep2[0]/3600;				
			$Eh = $Rep2[1]/3600;
			$Sum = $Sum+($Eh-$Sh);
			$MainOutput->OpenCol();
			$MainOutput->addoutput('<input type=text name=\'Sh'.$Rep2[3].'\' size=1 value='.$Sh.'>',0,0);
			$MainOutput->CloseCol();
			$MainOutput->OpenCol();
			$MainOutput->addtexte('à');
			$MainOutput->CloseCol();					
			$MainOutput->OpenCol();
			$MainOutput->addoutput('<input type=text name=\'Eh'.$Rep2[3].'\' size=1 value='.$Eh.'>',0,0);
			$MainOutput->CloseCol();
			$MainOutput->CloseRow();
		}
		$MainOutput->CloseRow();
		$MainOutput->CloseTable();
		$MainOutput->CloseCol();
	}else{
		$MainOutput->OpenCol(50);
		$MainOutput->OpenTable();
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('',3);
		$MainOutput->Addtexte($v,'Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('',3);
		$MainOutput->Addtexte('Période non commencée','Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$MainOutput->CloseTable();
		$MainOutput->CloseCol();
	}
}
$MainOutput->OpenCol();
$MainOutput->addoutput('<input type=submit value=\'Envoyer\'> ',0,0);
$MainOutput->br();
$MainOutput->AddTexte('Total: '.$Sum.'h','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->OpenRow('');
$MainOutput->OpenCol('');
$MainOutput->AddTexte('Notes complémentaires','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('',7);
$MainOutput->AddOutput('<textarea name=FORMNotes cols=50>'.stripslashes($Notes).'</textarea>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();	
$MainOutput->AddOutput('</form>',0,0);
$MainOutput->CloseTable();


	$Req = "SELECT IDConfirmation, confirmation.Notes, Semaine FROM confirmation  WHERE IDEmploye=".$_COOKIE['IDEmploye']." ORDER BY Semaine DESC Limit 0,1";
	$SQL->SELECT($Req);
	if($SQL->NumRow()<>0){
		$Rep = $SQL->FetchArray();
		$ENDS = get_end_dates(0,$Rep[2]);
		$MainOutput->opentable('100%');
		
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
		$MainOutput->OpenCol('',8);
		$MainOutput->AddTexte('<div align=center>Dernières heures confirmées : Semaine du '. $ENDS['Start'].' au '.$ENDS['End'] .'</div>','Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$MainOutput->OpenRow();
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
				$MainOutput->AddTexte($Sh." à ".$Eh,'ok');
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
		$MainOutput->OpenRow('');
		$MainOutput->OpenCol('',8);
		$MainOutput->AddTexte('Notes: ','Titre');
		$MainOutput->AddTexte($Rep[1]);
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$MainOutput->CloseTable();
	}
echo $MainOutput->Send(1);

?>