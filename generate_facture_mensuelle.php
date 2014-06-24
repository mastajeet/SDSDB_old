<?PHP

if(isset($_POST['FORMGenerateCote'])){

$_POST['FORMCote'] = $_POST['FORMGenerateCote'];

	$SQL = new SQLclass();
	$SQL2 = new SQLclass();
	$SQLins = new SQLClass();
	
	$ThisMonth = date('n',time());
	$ThisYear = date('Y',time());
	
	if($ThisMonth==1){
		$LastMonth = 12;
		$LastMonthYear = $ThisYear -1;
	}else{
		$LastMonth = $ThisMonth -1;
		$LastMonthYear = $ThisYear;
	}

	$FirstDayOfLastMonth = mktime(0,0,0,$LastMonth,1,$LastMonthYear);
	$FirstWeekOfTheMonth = get_last_sunday(0,$FirstDayOfLastMonth);
	$FirstWeekDayOfTheMonth = date('w',$FirstDayOfLastMonth);
	
	$LastDayOfLastMonth = mktime(0,0,0,$ThisMonth,1,$ThisYear) - 24*60*60;
	$LastWeekOfTheMonth = get_last_sunday(0,$LastDayOfLastMonth);
	$LastWeekDayOfTheMonth = date('w',$LastDayOfLastMonth);
	
	
			
			$IDFacture = add_facture($_POST['FORMCote'],$FirstWeekOfTheMonth);
			
			//TraitementPremièreSemaine
				
			$ReqIDIns = "SELECT DISTINCT shift.IDInstallation FROM shift JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE installation.Cote='".$_POST['FORMCote']."' AND Semaine=".$FirstWeekOfTheMonth." ORDER BY Nom ASC";
			$SQLins->SELECT($ReqIDIns);
			while($Repins = $SQLins->FetchArray()){
			$Req = "SELECT Start, End, Jour, shift.TXH, installation.Nom, shift.Assistant, Ferie FROM shift JOIN installation JOIN client on shift.IDInstallation = installation.IDInstallation AND client.IDClient = installation.IDClient WHERE shift.IDInstallation = ".$Repins[0]." AND Semaine=".$FirstWeekOfTheMonth." and Jour >= $FirstWeekDayOfTheMonth ORDER BY installation.Nom ASC, Jour ASC, Assistant ASC, Start ASC";
			$SQL->SELECT($Req);
			$i =0;
			$Shift = array();
		
			while($Rep = $SQL->FetchArray()){
					$Titre = "Sauveteur";
				if($Rep[5])
					$Titre = "Deuxième Sauveteur";
				if($i>0 && $Shift[$i-1]['End'] == $Rep[0])
					$Shift[$i-1]['End'] = $Rep[1];
				else{
					$Shift[$i] = array('Start'=>$Rep[0],'End'=>$Rep[1],'Jour'=>$Rep[2],'TXH'=>$Rep[3],'Notes'=>$Titre.": ".$Rep[4],'Ferie'=>$Rep[6]);
					
					$i++;
				}
				
			}
	
			foreach($Shift as $v){
				
				
				$v['End'] = $v['End'] - bcmod($v['End'],36);
				$v['Start'] = $v['Start'] - bcmod($v['Start'],36);
				
				
				
				if($v['Start']==0 and $v['End']==14400)
					$v['Notes'] = $v['Notes']." (Minimum 4h)";
					
				if(is_ferie($v['Jour']*86400+$FirstWeekOfTheMonth)){
					if($v['Ferie']<>1){
						$v['TXH'] = $v['TXH']*$v['Ferie'];
						$v['Notes'] = $v['Notes']." (x".$v['Ferie']." Journée Fériée)";
					}
				}
			$Req = "INSERT INTO factsheet(`IDFacture`,`Start`,`End`,`Jour`,`TXH`,`Notes`) VALUES(".$IDFacture.",'".$v['Start']."','".$v['End']."','".$v['Jour']."','".$v['TXH']."','".addslashes($v['Notes'])."')";
			$SQL->Insert($Req);
			}
			update_facture_balance($IDFacture);
		}
		
		$Req = "UPDATE shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation SET Facture=1 WHERE `Semaine`=".$FirstWeekOfTheMonth." AND Cote='".$_POST['FORMCote']."' AND Jour >= $FirstWeekDayOfTheMonth ";
		$SQL->SELECT($Req);	
			
			
			$CurrentWeek = get_next_sunday(0,$FirstWeekOfTheMonth);
			//TraitementSemaineSubsequentes
			$SemaineMultiplicateur = 1;
			while($CurrentWeek < $LastWeekOfTheMonth){


		
					
					$ReqIDIns = "SELECT DISTINCT shift.IDInstallation FROM shift JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE installation.Cote='".$_POST['FORMCote']."' AND Semaine=".$CurrentWeek ." ORDER BY Nom ASC";
					$SQLins->SELECT($ReqIDIns);
					while($Repins = $SQLins->FetchArray()){
					$Req = "SELECT Start, End, Jour, shift.TXH, installation.Nom, shift.Assistant, Ferie FROM shift JOIN installation JOIN client on shift.IDInstallation = installation.IDInstallation AND client.IDClient = installation.IDClient WHERE shift.IDInstallation = ".$Repins[0]." AND Semaine=".$CurrentWeek." ORDER BY installation.Nom ASC, Jour ASC, Assistant ASC, Start ASC";
					$SQL->SELECT($Req);
					$i =0;
					$Shift = array();
				
					while($Rep = $SQL->FetchArray()){
							$Titre = "Sauveteur";
						if($Rep[5])
							$Titre = "Deuxième Sauveteur";
						if($i>0 && $Shift[$i-1]['End'] == $Rep[0])
							$Shift[$i-1]['End'] = $Rep[1];
						else{
							$Shift[$i] = array('Start'=>$Rep[0],'End'=>$Rep[1],'Jour'=>$Rep[2],'TXH'=>$Rep[3],'Notes'=>$Titre.": ".$Rep[4],'Ferie'=>$Rep[6]);
							
							$i++;
						}
						
					}
			
					foreach($Shift as $v){
						
						
						$v['End'] = $v['End'] - bcmod($v['End'],36);
						$v['Start'] = $v['Start'] - bcmod($v['Start'],36);
						
						
						
						if($v['Start']==0 and $v['End']==14400)
							$v['Notes'] = $v['Notes']." (Minimum 4h)";
							
						if(is_ferie($v['Jour']*86400+$CurrentWeek)){
							if($v['Ferie']<>1){
								$v['TXH'] = $v['TXH']*$v['Ferie'];
								$v['Notes'] = $v['Notes']." (x".$v['Ferie']." Journée Fériée)";
							}
						}
					$NuJour = $v['Jour'] + $SemaineMultiplicateur * 7;
					$Req = "INSERT INTO factsheet(`IDFacture`,`Start`,`End`,`Jour`,`TXH`,`Notes`) VALUES(".$IDFacture.",'".$v['Start']."','".$v['End']."','".$NuJour."','".$v['TXH']."','".addslashes($v['Notes'])."')";
					$SQL->Insert($Req);
					}
					update_facture_balance($IDFacture);
				}
				
				$Req = "UPDATE shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation SET Facture=1 WHERE `Semaine`=".$CurrentWeek." AND Cote='".$_POST['FORMCote'];
				$SQL->SELECT($Req);
				$CurrentWeek = get_next_sunday(0,$CurrentWeek);
				$SemaineMultiplicateur++;
			}
			
			//TraitementDernièreSemaine
								
					$ReqIDIns = "SELECT DISTINCT shift.IDInstallation FROM shift JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE installation.Cote='".$_POST['FORMCote']."' AND Semaine=".$CurrentWeek ." ORDER BY Nom ASC";
					$SQLins->SELECT($ReqIDIns);
					while($Repins = $SQLins->FetchArray()){
					$Req = "SELECT Start, End, Jour, shift.TXH, installation.Nom, shift.Assistant, Ferie FROM shift JOIN installation JOIN client on shift.IDInstallation = installation.IDInstallation AND client.IDClient = installation.IDClient WHERE shift.IDInstallation = ".$Repins[0]." AND Semaine=".$CurrentWeek." AND Jour <= $LastWeekDayOfTheMonth ORDER BY installation.Nom ASC, Jour ASC, Assistant ASC, Start ASC";
					$SQL->SELECT($Req);
					$i =0;
					$Shift = array();
				
					while($Rep = $SQL->FetchArray()){
							$Titre = "Sauveteur";
						if($Rep[5])
							$Titre = "Deuxième Sauveteur";
						if($i>0 && $Shift[$i-1]['End'] == $Rep[0])
							$Shift[$i-1]['End'] = $Rep[1];
						else{
							$Shift[$i] = array('Start'=>$Rep[0],'End'=>$Rep[1],'Jour'=>$Rep[2],'TXH'=>$Rep[3],'Notes'=>$Titre.": ".$Rep[4],'Ferie'=>$Rep[6]);
							
							$i++;
						}
						
					}
			
					foreach($Shift as $v){
						
						
						$v['End'] = $v['End'] - bcmod($v['End'],36);
						$v['Start'] = $v['Start'] - bcmod($v['Start'],36);
						
						
						
						if($v['Start']==0 and $v['End']==14400)
							$v['Notes'] = $v['Notes']." (Minimum 4h)";
							
						if(is_ferie($v['Jour']*86400+$CurrentWeek)){
							if($v['Ferie']<>1){
								$v['TXH'] = $v['TXH']*$v['Ferie'];
								$v['Notes'] = $v['Notes']." (x".$v['Ferie']." Journée Fériée)";
							}
						}
					$NuJour = $v['Jour'] + $SemaineMultiplicateur * 7;
					$Req = "INSERT INTO factsheet(`IDFacture`,`Start`,`End`,`Jour`,`TXH`,`Notes`) VALUES(".$IDFacture.",'".$v['Start']."','".$v['End']."','".$NuJour."','".$v['TXH']."','".addslashes($v['Notes'])."')";
					$SQL->Insert($Req);
					}
					update_facture_balance($IDFacture);
			
				
				$Req = "UPDATE shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation SET Facture=1 WHERE `Semaine`=".$CurrentWeek." AND Jour <= $LastWeekDayOfTheMonth  AND Cote='".$_POST['FORMCote'];
				$SQL->SELECT($Req);
							
		}
		
	$Modifie=TRUE;
	$_GET['IDFacture'] = $IDFacture;
	$MainOutput->emptyoutput();
	$MainOutput->addoutput(include('display_facture.php'),0,0);
		
	}
	else{
	
	$MainOutput->OpenTable();
	$MainOutput->OpenRow();
	$MainOutput->Opencol();
	
	$MainOutput->AddTexte('Mois Passé','Titre');
 	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	$SQL = new SQLclass();
	$Req = "SELECT Nom, Cote FROM client WHERE FrequenceFacturation = 'M'";
	$SQL->SELECT($Req); 
	$Installation = array();
	while($Rep = $SQL->FetchArray()){
		$Installation[$Rep[1]] = $Rep[0]; 
	}
	
	$MainOutput->OpenRow();
	$MainOutput->Opencol();
		$MainOutput->addform('Ajouter une facture');
		$MainOutput->inputhidden_env('Section','Generate_Facture_Mensuelle');
		$MainOutput->InputRadio('GenerateCote',$Installation,'','Piscine','VER');
		$MainOutput->formsubmit('Créer');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->CloseTable();
	
	
	
	}
	
	
	
	
		echo $MainOutput->send(1);