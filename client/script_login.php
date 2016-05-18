<?PHP
	$Req = "SELECT distinct client.IDClient, client.Password from client JOIN installation on client.IDClient = installation.IDClient WHERE installation.Cote ='".strtoupper($_POST['FORMCote'])."'";
	$SQL->SELECT($Req);
		$MauvaisID = "Mauvais identifiants, veuillez vous réidentifier";
	if($SQL->NumRow()==0){
		$WarnOutput->addtexte($MauvaisID,'Warning');
	}else{
		$Rep = $SQL->FetchArray();	
		if($Rep['Password']<>$_POST['FORMPassword'])
			$WarnOutput->addtexte($MauvaisID,'Warning');
		else{
			$Req = "UPDATE client set NBAcces = NBAcces-1 where IDClient = ".$Rep['IDClient'];
			$SQL->update($Req);
			setcookie('IDClient',$Rep['IDClient'],time()+3600*24);
			setcookie('CIE',$_POST['FORMCIE'],time()+3600*24);
			?>
			<script>
			window.location = 'index.php?Section=Display_Shift'
			</script>
			<?PHP
		}
	}
?>