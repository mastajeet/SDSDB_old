<?PHP


const SHIFT_TO_CONFIRM = '<div align=center>Heure à confirmer</div>';

$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
$SQL = new sqlclass;
$SQL2 = new sqlclass;
$Req = "SELECT IDConfirmation, IDEmploye, confirmation.Notes FROM confirmation WHERE Semaine = ".$_GET['Semaine']." AND !Confirme ";
$SQL->SELECT($Req);
$c="two";


if($SQL->NumRow()<>0){
	
	
	
	
	
	$MainOutput->opentable('100%');
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('',8);
		$MainOutput->AddTexte(SHIFT_TO_CONFIRM,'Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	

	while($Rep = $SQL->FetchArray()){

        $employe = new Employee($Rep['1']);
	$MainOutput->addoutput('<form action=index.php method=POST>',0,0);
	$MainOutput->inputhidden_env('Action','Conf_Shift');
	$MainOutput->inputhidden_env('IDConfirmation',$Rep[0]);
	$MainOutput->inputhidden_env('Semaine',$_GET['Semaine']);
	
	if($c=="two")
		$c="one";
	else
		$c="two";	
		
		$MainOutput->OpenRow('',$c);
		$MainOutput->OpenCol('',8);
			$MainOutput->AddTexte($employe->getHoraireName(),'Titre');
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
		$MainOutput->OpenRow('',$c);
			$Sum=0;
		foreach($CJour as $k=>$v){
		$Installation ="";
	
			$Req2 = "SELECT confshift.Start, confshift.End, Nom, shift.IDShift FROM shift JOIN confshift JOIN installation ON confshift.IDShift = shift.IDShift AND shift.IDInstallation = installation.IDInstallation WHERE confshift.IDConfirmation=".$Rep[0]." AND Jour='".$k."' ORDER BY confshift.Start ASC";
			$SQL2->Select($Req2);
		
			$MainOutput->OpenCol(50);
				$MainOutput->OpenTable();
				$MainOutput->OpenRow();
				
				$MainOutput->OpenCol('',3);
					$MainOutput->Addtexte($v,'Titre');
				$MainOutput->CloseCol();
				
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
	
	
		}
		
			$MainOutput->OpenCol();
				$MainOutput->addoutput('<input type=submit value=\'Confirmer\'> </form>',0,0);
				$MainOutput->br();
				$MainOutput->AddTexte('Total: '.$Sum.'h','Titre');
			$MainOutput->CloseCol();
		$MainOutput->CloseRow();
	
		$MainOutput->OpenRow('',$c);
		$MainOutput->OpenCol('',8);
			$MainOutput->AddTexte('Notes: ','Titre');
			$MainOutput->AddTexte($Rep[2]);
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
	
		
	}
	$MainOutput->CloseTable();
}else{
include('display_shift.php');
}
echo $MainOutput->send(1);
?>