<?PHP
$SQL = new sqlclass;
$SQL2 = new sqlclass;
if(isset($_GET['Semaine']) && !isset($_POST['FORMGenerateCote'])){
	$MainOutput->OpenTable();
	$MainOutput->OpenRow();
	$MainOutput->Opencol();
	$ENDS = get_end_dates(0,$_GET['Semaine']);
	$MainOutput->AddTexte('Semaine du '.$ENDS['Start'].' au '.$ENDS['End'],'Titre');
 	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$Req = "SELECT Cote, sum(Facture) as a FROM shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE `Semaine`=".$_GET['Semaine']." GROUP BY Cote ORDER BY Cote ASC";
	$SQL->select($Req);
	$Installation = array();
	while($Rep = $SQL->FetchArray()){
		if($Rep[1]==0)
			$Installation[$Rep[0]] = get_associated_cote($Rep[0]);
	}
	$MainOutput->OpenRow();
	$MainOutput->Opencol();
		$MainOutput->addform('Ajouter une facture');
		$MainOutput->inputhidden_env('Section','Generate_Facture');
		$MainOutput->inputhidden_env('Semaine',$_GET['Semaine']);
		$MainOutput->InputRadio('GenerateCote',$Installation,'','Piscine','VER');
		$MainOutput->formsubmit('Cr�er');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->CloseTable();
}elseif(isset($_POST['Semaine']) AND isset($_POST['FORMGenerateCote'])){
$_POST['FORMCote'] = $_POST['FORMGenerateCote'];
//IL FAUT CH�KER SI LES HEURES ONT PAS DEJA �T� FACTU�ES
$Req = "SELECT sum(Facture) as a FROM shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE `Semaine`=".$_POST['Semaine']." AND installation.Cote='".$_POST['FORMCote']."' GROUP BY Cote";
$SQL->select($Req);
$Rep = $SQL->FetchArray();
if($Rep[0]>0){
	$MainOutput->AddTexte('La facture pour cette p�riode est d�j� faite','Warning');
}elseif($_POST['Semaine']>=get_last_sunday(0,time())){
	$MainOutput->AddTexte('Vous ne pouvez pas faire la facturation pour une p�riode non compl�t�e','Warning');
}else{
	$SQLins = new sqlclass();
	$ReqIDIns = "SELECT DISTINCT shift.IDInstallation FROM shift JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE installation.Cote='".$_POST['FORMCote']."' AND Semaine=".$_POST['Semaine']." ORDER BY Nom ASC";
	$SQLins->SELECT($ReqIDIns);
	while($Repins = $SQLins->FetchArray()){
		$Req = "SELECT Start, End, Jour, shift.TXH, installation.Nom, shift.Assistant, Ferie, shift.IDEmploye FROM shift JOIN installation JOIN client on shift.IDInstallation = installation.IDInstallation AND client.IDClient = installation.IDClient WHERE shift.IDInstallation = ".$Repins[0]." AND Semaine=".$_POST['Semaine']." ORDER BY installation.Nom ASC, Jour ASC, Assistant ASC, Start ASC";
		$SQL->SELECT($Req);
		$i =0;
		$Shift = array();
	
		while($Rep = $SQL->FetchArray()){
				$Titre = "Sauveteur";
			if($Rep[5])
				$Titre = "Deuxi�me Sauveteur";
			if($i>0 && ($Shift[$i-1]['End'] == $Rep[0]) and ($Shift[$i-1]['Jour']==$Rep[2])){
				$Shift[$i-1]['End'] = $Rep[1];
                $Shift[$i-1]['Notes'] = substr($Shift[$i-1]['Notes'],0,-1);
                $Shift[$i-1]['Notes'] .= "-".get_employe_initials($Rep[7]).")";
            }else{
				$Shift[$i] = array('Start'=>$Rep[0],'End'=>$Rep[1],'Jour'=>$Rep[2],'TXH'=>$Rep[3],'Notes'=>$Titre.": ".$Rep[4]." (".get_employe_initials($Rep[7]).")",'Ferie'=>$Rep[6]);
				
				$i++;
			}
			
		}
		$IDFacture = add_facture($_POST['FORMCote'],$_POST['Semaine']);

		foreach($Shift as $v){

			$v['End'] = $v['End'] - bcmod($v['End'],36);
			$v['Start'] = $v['Start'] - bcmod($v['Start'],36);

			if($v['Start']==0 and $v['End']==14400)
				$v['Notes'] = $v['Notes']." (Minimum 4h)";
				
			if(is_ferie($v['Jour']*86400+$_POST['Semaine'])){
				if($v['Ferie']<>1){
					$v['TXH'] = $v['TXH']*$v['Ferie'];
					$v['Notes'] = $v['Notes']." (x".$v['Ferie']." Journ�e F�ri�e)";
				}
			}
		$Req = "INSERT INTO factsheet(`IDFacture`,`Start`,`End`,`Jour`,`TXH`,`Notes`) VALUES(".$IDFacture.",'".$v['Start']."','".$v['End']."','".$v['Jour']."','".$v['TXH']."','".addslashes($v['Notes'])."')";
		$SQL->Insert($Req);
		}
		update_facture_balance($IDFacture);
	}
	
	$Req = "UPDATE shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation SET Facture=1 WHERE `Semaine`=".$_POST['Semaine']." AND Cote='".$_POST['FORMCote']."'";
	$SQL->Query($Req);
	$Modifie=TRUE;
	$_GET['IDFacture'] = $IDFacture;
	$MainOutput->emptyoutput();
	$MainOutput->addoutput(include('display_facture.php'),0,0);
	}
	
}
echo $MainOutput->send(1);