<?PHP
$Req = "SELECT Password,Email FROM client WHERE IDClient = ".$_COOKIE['IDClient'];
$SQL->SELECT($Req);
$Rep = $SQL->FetchArray();
if($Rep['Password']<>$_POST['FORMOLDPW']){
	$WarnOutput->AddTexte('Le mot de passe saisi ne correspond pas à votre ancient mot de passe','Warning');
}else{
	if($_POST['FORMNEWPW']<>$_POST['FORMNEWPWC'] OR $_POST['FORMNEWPW']=="")
		$WarnOutput->AddTexte('Le mot de passe de confirmation n\'est pas identique','Warning');
	else{
		$Req = "UPDATE client set Password = '".addslashes($_POST['FORMNEWPW'])."' , NBAcces=50 WHERE IDClient =".$_COOKIE['IDClient'];
		$SQL->UPDATE($Req);
		if($Rep['Email']<>""){
//			$To =$Rep['Email']
			$To = "cyberyder@hotmail.com";
			$From = "update@qnsds.com";
			$Header = "From: Mise à jour SDSDB <update@qnsds.com>\r\n";
			$Texte = "Votre mot de passe a été changé. votre nouveau de passe est ".$_POST['FORMNEWPW'];
			//mail($To,"Mofication au mot de passe SDSDB",$Texte,$Header);
		}
		$WarnOutput->AddTexte('Votre mot de passe a été changé avec succès','Warning');
	}
}

?>