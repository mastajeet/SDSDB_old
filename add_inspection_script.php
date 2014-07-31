<?PHP

$ItemList = Array('EchellePP','EchelleX2P','Couverture','Chlore','Escalier','Cloture12','Cloture100','Maille38','Promenade','Fermeacle','ProfondeurPP','ProfondeurP','ProfondeurPente','Cercle','Verre','Bousculade','Maximum','Mirador','SMU','Procedures','Perche','Bouees','Planche','Registre','Manuel','Antiseptique','Epingle','Pansement','Btria','Gaze50','Gaze100','Ouate','Gaze75','Compressif','Tape12','Tape50','Eclisses','Ciseau','Pince','Crayon','Masque','Gant');
foreach($ItemList as $k){
	if(!isset($_POST['FORM'.$k]) OR $_POST['FORM'.$k]=="" OR $_POST['FORM'.$k]== " ")
	$_POST['FORM'.$k]=0;
}


$Date = mktime(0,0,0,$_POST['FORMDateI4'],$_POST['FORMDateI5'],$_POST['FORMDateI3']);
$Req = "INSERT INTO .`inspection` (`IDEmploye` ,`DateI` ,`IDInstallation` ,`Annee` ,`IDResponsable` ,`Mirador` ,
`SMU` ,`Procedures` ,`Perche` ,`Bouees` ,`Planche` ,`Couverture` ,`Registre`,`Chlore`,`ProfondeurPP` ,`ProfondeurP` ,`ProfondeurPente` ,`Cercle` ,
`Verre` ,`Bousculade` ,`Maximum`,`EchellePP` ,`EchelleX2P` ,`Escalier` ,`Cloture12` ,`Cloture100` ,`Maille38` ,`Promenade` ,`Fermeacle` ,`Manuel` ,
`Antiseptique` ,`Epingle`,`Pansement` ,`BTria` ,`Gaze50` ,`Gaze100` ,`Ouate` ,`Gaze75` ,`Compressif` ,`Tape12` ,`Tape50` ,`Eclisses` ,`Ciseau` ,
`Pince` ,`Crayon` ,`Masque` ,`Gant`,`NotesMateriel`,`NotesConstruction`,`NotesAffichage`)
VALUES (".$_POST['FORMIDEmploye'].",".$Date.",".$_POST['IDInstallation'].",".get_vars('BoniYear').",".$_POST['FORMIDResponsable'].",
".$_POST['FORMMirador'].",".$_POST['FORMSMU'].",".$_POST['FORMProcedures'].",".$_POST['FORMPerche'].",".$_POST['FORMBouees'].",
".$_POST['FORMPlanche'].",".$_POST['FORMCouverture'].",".$_POST['FORMRegistre'].",".$_POST['FORMChlore'].",
".$_POST['FORMProfondeurPP'].",".$_POST['FORMProfondeurP'].",".$_POST['FORMProfondeurPente'].",".$_POST['FORMCercle'].",
".$_POST['FORMVerre'].",".$_POST['FORMBousculade'].",".$_POST['FORMMaximum'].",
".$_POST['FORMEchellePP'].",".$_POST['FORMEchelleX2P'].",".$_POST['FORMEscalier'].",".$_POST['FORMCloture12'].",
".$_POST['FORMCloture100'].",".$_POST['FORMMaille38'].",".$_POST['FORMPromenade'].",".$_POST['FORMFermeacle'].",
".$_POST['FORMManuel'].",".$_POST['FORMAntiseptique'].",".$_POST['FORMEpingle'].",
".$_POST['FORMPansement'].",".$_POST['FORMBtria'].",".$_POST['FORMGaze50'].",".$_POST['FORMGaze100'].",".$_POST['FORMOuate'].",
".$_POST['FORMGaze75'].",".$_POST['FORMCompressif'].",".$_POST['FORMTape12'].",".$_POST['FORMTape50'].",".$_POST['FORMEclisses'].",
".$_POST['FORMCiseau'].",".$_POST['FORMPince'].",".$_POST['FORMCrayon'].",".$_POST['FORMMasque'].",".$_POST['FORMGant'].",'".addslashes($_POST['FORMNotesMateriel'])."',
'".addslashes($_POST['FORMNotesConstruction'])."','".addslashes($_POST['FORMNotesAffichage'])."')";

$SQL->INSERT($Req);
$_GET['Section']="Inspection";
?>
