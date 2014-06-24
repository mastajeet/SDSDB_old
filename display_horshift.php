<?PHP
$MainOutput->OpenTable();
if(!isset($_GET['ToPrint'])){
	$_GET['ToPrint']=False;
}

	$MainOutput->OpenRow();
 	$MainOutput->OpenCol(900,8);
	if(!$_GET['ToPrint']){
		$MainOutput->addlink('index.php?Section=Display_Horshift&ToPrint=TRUE','<img border=0 src=b_print.png>','_BLANK');
	}
		 $MainOutput->addtexte('<div align=Center>Horaire hebdomadaire officiel','Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();


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
			$MainOutput->closecol();
		}
	$MainOutput->CloseRow();
	
	


	$Req2 = "SELECT installation.IDHoraire, installation.Nom, horaire.nom, IDInstallation, count(IDHorshift) as a FROM installation JOIN horaire JOIN horshift ON installation.IDHoraire = horaire.IDHoraire AND installation.IDHoraire = horshift.IDHoraire WHERE Actif AND Saison GROUP BY installation.IDInstallation ORDER BY IDClient ASC, installation.Nom ASC";

	$SQL = new sqlclass;
	$SQL->SELECT($Req2);
	while($Rep = $SQL->FetchArray()){
		
	
		
		
	$MainOutput->openrow();
	$MainOutput->opencol('100%',1,'center','HInstall');
	$MainOutput->addlink('index.php?Section=Horshift&IDInstallation='.$Rep[3],"<div align=center>".$Rep[1]."</div>");
	$MainOutput->addoutput("<div align=center>",0,0);
		$MainOutput->addlink('index.php?Action=Modifie_Horshift&Empty=TRUE&IDHoraire='.$Rep[0],'<img border=0 src=b_save.png>');
		$MainOutput->addlink('index.php?Action=Modifie_Horshift&Reset=TRUE&IDHoraire='.$Rep[0].'&IDInstallation='.$Rep[3],'<img border=0 src=b_del.png>');
	$MainOutput->addoutput("</div>",0,0);
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
						$MainOutput->addtexte('<div align=center>'.$CJour[$d].'</div>');
					$MainOutput->closecol();
					$MainOutput->closerow();
				$MainOutput->closetable();	
					

				$MainOutput->opentable();
				$Info = get_day_shift($Rep[0],$d);
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
						$MainOutput->AddLink('index.php?Section=Horshift_Form&IDHorshift='.$v['IDHorshift'],'<img src=b_edit.png border=0>');
					$MainOutput->closecol();
					$MainOutput->closerow();
					
					$MainOutput->openrow();
					$Diplay="";
					if($v['Confirm']==1)
						$MainOutput->opencol('','1','top','ok');
					else				
						$MainOutput->opencol('','1','top','unconfirmed');
						
						$SQL2 = new sqlclass;
						$Req2 = "SELECT Nom, Prenom , HName FROM employe WHERE IDEmploye = '".$v['IDEmploye']."' and IDEmploye <>0";
						$SQL2->Query($Req2);
						$Rep2 = $SQL2->FetchArray();
						if($Rep2[2]=="")
							$Display = substr($Rep2[1]."&nbsp;".$Rep2[0],0,20);
						else
							$Display = $Rep2[2];

						
						if($SQL2->NumRow())
							$MainOutput->addlink('index.php?Section=Employe&IDEmploye='.$v['IDEmploye'],$Display);
						else
							$MainOutput->addTexte('&nbsp');
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
