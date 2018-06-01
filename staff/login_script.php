<?PHP
define('IN_HALF_A_YEAR', time() + 60 * 60 * 24 * 180);
if(isset($_POST['FORMIDEmploye']) && isset($_POST['FORMNAS'])){


    $variable = new Variable();
    $password_getter = new PasswordGetter($variable);
    $authorization = new Authorization($password_getter);

    $Req = "SELECT NAS, Cessation, Status FROM employe WHERE IDEmploye =".$_POST['FORMIDEmploye'];
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();

	if(!$Rep['Cessation']){
        setcookie("Bureau", 0, IN_HALF_A_YEAR);

        if($Rep['Status']=="Bureau"){
		    //checkweather password is bureau or super_admin
            $encrypted_password = md5($_POST['FORMNAS']);
            if($encrypted_password==get_vars('MP')){
                setcookie("Bureau", 1, IN_HALF_A_YEAR);
                setcookie("MP",$encrypted_password, IN_HALF_A_YEAR);

                #On se prepare pour le login 2.0 avec le pass encrypted dans le cookie....
                setcookie($authorization::KEY_AUTHORIZATION_LEVEL, $authorization::AUTHORIZATION_LEVEL_BUREAU, IN_HALF_A_YEAR);
                setcookie($authorization::KEY_PASSWORD, $encrypted_password, IN_HALF_A_YEAR);
            }elseif($password_getter->get_super_admin_password()==$encrypted_password){
                setcookie($authorization::KEY_AUTHORIZATION_LEVEL, $authorization::AUTHORIZATION_LEVEL_SUPER_ADMIN, IN_HALF_A_YEAR);
                setcookie($authorization::KEY_PASSWORD, $encrypted_password, IN_HALF_A_YEAR);

                #Juste pour le legacy support, on se log old school au bureau, et on met le mot de passe en clair dans le cookie....
                setcookie("Bureau", 1, IN_HALF_A_YEAR);
                setcookie("MP",get_vars('MP'), IN_HALF_A_YEAR);
            }
		}


        if( strlen($_POST['FORMNAS'])>0 and (substr($Rep[0],6,3)==$_POST['FORMNAS'] or $encrypted_password==get_vars('MP') or $encrypted_password == $password_getter->get_super_admin_password())){
		setcookie("IDEmploye", $_POST['FORMIDEmploye'], IN_HALF_A_YEAR);
		setcookie("CIESDS", $_POST['FORMCIESDS'], IN_HALF_A_YEAR);

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
		$WarningOutput->AddTexte('Acces Non Autorise','Warning');
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