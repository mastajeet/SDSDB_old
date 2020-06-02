<?
$Info = get_employe_info($_GET['IDEmploye']);
if($Info['Email']==""){
	$MainOutput->AddTexte('Cet employé n\'a pas d\'adresse de courriel.','Warning');
}else{
	$Semaine = array(get_last_sunday(),get_next_sunday());
	$MailString = get_employe_horaire_email($_GET['IDEmploye'],$Semaine);
	$FinalString = "<html>\n";
	$FinalString .= "<body>\n";
	$FinalString .= "<font face=tahoma size=2><b>Bonjour ".$Info['Prenom'].", voici ton horaire pour la semaine courante ainsi que celle de la semaine prochaine</b></font><br \><br>". $MailString."</html>";

	send_mail($Info['Email'],"Horaire",$FinalString);
	$MainOutput->AddTexte('Le couriel a été envoyé avec succès à: '.$Info['Prenom'].' '.$Info['Nom'].' '.htmlspecialchars('<').$Info['Email'].htmlspecialchars('>').'<br><br>','Warning'); 
	$MainOutput->AddOutput($FinalString,0,0);
}


echo $MainOutput->Send(1);
?>