<?PHP
$SQL2 = new sqlclass();
$MainOutput->OpenTable(700);
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',7);
		if(!$_GET['ToPrint']){
		$MainOutput->addlink('index.php?Section=Add_Remplacement&Semaine='.$_GET['Semaine'],'<img border=0 src=b_ins.png>');
		$MainOutput->addlink('index.php?Section=Remplacement&ToPrint=TRUE','<img border=0 src=b_print.png>','_BLANK');
}
	$MainOutput->AddTexte('Liste des shifts à combler','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
	if(isset($Rapport)){
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',7);
		$MainOutput->AddOutput($Rapport->Send(1),0,0);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	}

$Today = Get_last_sunday() + date('w',time());
$Then = $Today+14*24*60*60;

$Req = "
SELECT 
shift.IDShift, IDInstallation, IDRemplacement, `Semaine`,`Jour`,`Start`, `End`, remplacement.Confirme, IDEmployeS, IDEmployeE, Talkedto, Asked 
FROM 
shift LEFT JOIN remplacement 
ON
remplacement.IDShift = shift.IDShift
WHERE 
(shift.IDEmploye = 0 || IDRemplacement) AND
Semaine + Jour*60*60*24 >= ".$Today." AND 
Semaine + Jour*60*60*24 <= ".$Then."
ORDER BY 
Semaine+Jour*60*60*24+`Start` ASC";
$SQL->SELECT($Req);
$Month = get_month_list();
$Semaine = "";
$Jour = "";
while($Rep = $SQL->FetchArray()){
	if($Rep['Confirme']<>1){
		if($Semaine<>$Rep['Semaine'] || $Jour<>$Rep['Jour']){
		$Date = get_date($Rep['Semaine']+$Rep['Jour']*24*60*60);
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',7);
			$MainOutput->addtexte("&nbsp;", 'Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',7);
			$MainOutput->addtexte("<div align=center>".$Date['d']."-".$Month[intval($Date['m'])]."</div>", 'Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$Semaine = $Rep['Semaine'];
		$Jour = $Rep['Jour'];
		}	
		$Req2 = "SELECT Nom FROM installation JOIN shift on shift.IDInstallation = installation.IDInstallation WHERE IDShift = ".$Rep['IDShift'];
		$SQL2->SELECT($Req2);
		$Rep2 = $SQL2->FetchArray();
		$MainOutput->OpenRow();
	
		$MainOutput->OpenCol('10');
			if($Rep['Confirme']!=NULL)
				$MainOutput->AddLink('index.php?Action=Confirm_Remplacement&IDRemplacement='.$Rep['IDRemplacement'],'<img src=b_conf.png border=0>');
			else
				$MainOutput->AddTexte('&nbsp;');
		$MainOutput->CloseCol();
		
		$MainOutput->OpenCol('10');
				$MainOutput->AddLink('index.php?Section=Shift_Form&IDShift='.$Rep['IDShift'],'<img src=b_edit.png border=0>');
		$MainOutput->CloseCol();
	
		$MainOutput->OpenCol('150');
			$MainOutput->addtexte($Rep2[0],'Titre');
		$MainOutput->CloseCol();
		
		$Start= get_date($Rep['Start']);
		$End = get_date($Rep['End']);
					if($Start['i']==0)
						$Start['i']="";
					if($End['i']==0)
						$End['i']="";
		
		$MainOutput->OpenCol('40');
				$MainOutput->addtexte($Start['G']."h".$Start['i']."&nbsp;à&nbsp;".$End['G']."h".$End['i']);
		$MainOutput->CloseCol();

				$MainOutput->OpenCol('80');
		if($Rep['IDEmployeE']<>NULL || $Rep['IDEmployeE']<>0){
			$EInfo = get_employe_info($Rep['IDEmployeE']);
			if($EInfo['Prenom']<>""){

				$Field = $EInfo['Prenom']." ".$EInfo['Nom'];
				$MainOutput->addtexte($Field,'Ok');
			}else{
				$Field = "_____________________";
				$MainOutput->addtexte($Field);
			}
		}else{

			$Field = "_____________________";
					$MainOutput->addtexte($Field);
		}

		$MainOutput->CloseCol();
		
		
		
		$MainOutput->OpenCol('400');
		if($Rep['IDEmployeS']<>""){
			$MainOutput->addtexte('Demandé par ','Small');
		$EInfo = get_employe_info($Rep['IDEmployeS']);
		
		if($EInfo['HName']=="")
			$EInfo['HName'] = $EInfo['Prenom']." ".$EInfo['Nom'];
			$MainOutput->AddLink('index.php?Section=Employe&IDEmploye='.$Rep['IDEmployeS'],$EInfo['HName'],'_BLANK','Small');
		$Date = get_date($Rep['Asked']);
			$MainOutput->AddTexte(' le '.$Date['d'].' '.$Month[intval($Date['m'])],'Small');
			$EInfo = get_employe_info($Rep['Talkedto']);
			$MainOutput->AddTexte(' à '.$EInfo['Prenom']." ".$EInfo['Nom'],'Small');
		}else{
			$MainOutput->AddTexte('&nbsp;','Small');
		}
		$MainOutput->CloseCol();
		
		
	
		$MainOutput->CloseRow();
		
		
		
		
	}
}





$MainOutput->CloseTable();
echo $MainOutput->Send(1);
?>