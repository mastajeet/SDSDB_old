<?PHP
	if($_POST['IDShift']==0){
		$Temps = mktime($_POST['FORMTemps2'],$_POST['FORMTemps1'],0,$_POST['FORMTemps4'],$_POST['FORMTemps5'],$_POST['FORMTemps3']);
		$IDShift = trouver_shift($_POST['FORMIDInstallation'],$Temps);
	}else
        $IDShift = $_POST['IDShift'];

if(!isset($_POST['IDShift']) or $_POST['IDShift']==""){
    $_POST['IDShift']=0;
}
	$ShiftInfo = get_info('shift',$IDShift = $_POST['IDShift']);
    $InstallationInfo = get_info('installation',$ShiftInfo['IDInstallation']);
    $ResponsableInfo = get_info('responsable',$_POST['FORMIDResponsable']);
    $EmployeInfo = get_info('employe',$ShiftInfo['IDEmploye']);
	$Req = "INSERT INTO commentaire(`IDResponsable`,`IDEmploye`,`IDShift`,`Commentaire`) VALUES(".$_POST['FORMIDResponsable'].",".$_POST['FORMIDEmploye'].",".$IDShift.",'".addslashes($_POST['FORMCommentaire'])."')";

    $Titre = 	'Commentaire de '.$ResponsableInfo['Prenom'].' '.$ResponsableInfo['Prenom'];
    $Body = "Rapport pour ".$EmployeInfo['Prenom']." ".$EmployeInfo['Nom']."
    ".addslashes($_POST['FORMCommentaire']);
    mail('info@servicedesauveteurs.com',$Titre,$Body);
    $SQL->INSERT($Req);
	$WarnOutput->br(2);
	$WarnOutput->AddTexte('Votre commentaire à été envoyé, il sera traité dans les 24h ouvrables et sera transmis au sauveteur concerné.','Warning');
	$WarnOutput->br(2);
	$WarnOutput->AddTexte('Merci et bonne journée','Warning');
?>