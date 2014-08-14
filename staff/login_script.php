<?PHP
if(isset($_POST['FORMIDEmploye']) && isset($_POST['FORMNAS'])){
	$Req = "SELECT NAS FROM employe WHERE IDEmploye =".$_POST['FORMIDEmploye'];
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
        if($_POST['FORMNAS']==get_vars('MP')){
            setcookie("Bureau", 1, time()+60*60*24*180);
            setcookie("MP",get_vars('MP'), time()+60*60*24*180);
            
        }else{
            setcookie("Bureau", 0, time()+60*60*24*180);
        }
        
	if(substr($Rep[0],6,3)==$_POST['FORMNAS'] or $_POST['FORMNAS']==get_vars('MP')){
	setcookie("IDEmploye", $_POST['FORMIDEmploye'], time()+60*60*24*180);
	setcookie("CIESDS", $_POST['FORMCIESDS'], time()+60*60*24*180);
         
		?>
		<script>
		window.location = 'index.php';
		</script>
		<?PHP

	}else{
		$WarningOutput->br(2);
		$WarningOutput->AddTexte('Mauvais identifiants','Warning');
		$Date = getdate(time());
		$DateStr = $Date['mday']."-".$Date['mon']."-".$Date['year'];
		$IP = $_SERVER['REMOTE_ADDR'];
		$Req = "INSERT Into login(`Username`,`Password`,`IP`,`Time`) VALUES(".$_POST['FORMIDEmploye'].",".$_POST['FORMNAS'].",'".$IP."','".$DateStr."')";
		$SQL->INSERT($Req);
	}
}else{
	$WarningOutput->br(2);
	$WarningOutput->AddTexte('Veuillez entrer vos identifiants','Warning');
}
?>