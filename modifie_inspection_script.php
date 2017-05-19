<?PHP


$ItemList = Array('EchellePP','EchelleX2P','Escalier','Cloture12','Chlore','Couverture','Cloture100','Maille38','Promenade','Fermeacle','ProfondeurPP','ProfondeurPP','ProfondeurPente','Cercle','Verre','Bousculade','Maximum','Mirador','SMU','Procedures','Perche','Bouees','Planche','Registre','Manuel','Antiseptique','Epingle','Pansement','Btria','Gaze50','Gaze100','Ouate','Gaze75','Compressif','Tape12','Tape50','Eclisses','Ciseau','Pince','Crayon','Masque','Gant');
foreach($ItemList as $k){
	if(!isset($_POST['FORM'.$k]) OR $_POST['FORM'.$k]=="")
	$_POST['FORM'.$k]=0;
}
$Date = mktime(0,0,0,$_POST['FORMDateI4'],$_POST['FORMDateI5'],$_POST['FORMDateI3']);
$Req = "UPDATE inspection SET 
DateI= ".$Date.", NotesBouees=''".addslashes($_POST['FORMNotesBouees'])."'


`Mirador`=".$_POST['FORMMirador'].",`SMU`=".$_POST['FORMSMU'].",`Procedures`=".$_POST['FORMProcedures'].",
`Perche`=".$_POST['FORMPerche'].", `Bouees`=".$_POST['FORMBouees'].",`Planche`=".$_POST['FORMPlanche'].",
`Couverture`=".$_POST['FORMCouverture'].", `Registre`=".$_POST['FORMRegistre'].", `Chlore`=".$_POST['FORMChlore'].",
`ProfondeurPP`=".$_POST['FORMProfondeurPP'].",`ProfondeurP`=".$_POST['FORMProfondeurP'].",`ProfondeurPente`=".$_POST['FORMProfondeurPente'].",
`Cercle`=".$_POST['FORMCercle'].",`Verre`=".$_POST['FORMVerre'].",`Bousculade`=".$_POST['FORMBousculade'].",`Maximum`=".$_POST['FORMMaximum'].",
`EchellePP`=".$_POST['FORMEchellePP'].",`EchelleX2P`=".$_POST['FORMEchelleX2P'].",
`Escalier`=".$_POST['FORMEscalier'].",`Cloture12`=".$_POST['FORMCloture12'].",`Cloture100`=".$_POST['FORMCloture100'].",
`Maille38`=".$_POST['FORMMaille38'].",`Promenade`=".$_POST['FORMPromenade'].",`Fermeacle`=".$_POST['FORMFermeacle'].",
`Manuel`=".$_POST['FORMManuel'].",`Antiseptique`=".$_POST['FORMAntiseptique'].",`Epingle`=".$_POST['FORMEpingle'].",
`Pansement`=".$_POST['FORMPansement'].",`Btria`=".$_POST['FORMBtria'].",`Gaze50`=".$_POST['FORMGaze50'].",
`Gaze100`=".$_POST['FORMGaze100'].",`Ouate`=".$_POST['FORMOuate'].",`Gaze75`=".$_POST['FORMGaze75'].",
`Compressif`=".$_POST['FORMCompressif'].",`Tape12`=".$_POST['FORMTape12'].",`Tape50`=".$_POST['FORMTape50'].",
`Eclisses`=".$_POST['FORMEclisses'].",`Ciseau`=".$_POST['FORMCiseau'].",`Pince`=".$_POST['FORMPince'].",
`Crayon`=".$_POST['FORMCrayon'].",`Masque`=".$_POST['FORMMasque'].",`Gant`=".$_POST['FORMGant'].",
 `NotesMateriel`='".addslashes($_POST['FORMNotesMateriel'])."',`NotesConstruction`='".addslashes($_POST['FORMNotesConstruction'])."',`NotesAffichage`='".addslashes($_POST['FORMNotesAffichage'])."'
WHERE IDInspection = ".$_POST['IDInspection'];
$SQL->Query($Req);
$_GET['Section'] = "Inspection";
?>