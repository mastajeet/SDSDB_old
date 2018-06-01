<?PHP

if(isset($_REQUEST['Action'])){

	SWITCH($_REQUEST['Action']){

		CASE "Login":{
				include('staff/login_script.php');
		BREAK;
		}
		
		CASE "Confirm_Heures":{
				include('staff/confirm_heures_script.php');
		BREAK;
		}

		CASE "Delog":{
            setcookie('IDEmploye','',0);
            setcookie('CIE','',0);
            setcookie('CIESDS','',0);
            setcookie('MP','',0);
            setcookie('Bureau','',0);
            setcookie(Authorization::KEY_AUTHORIZATION_LEVEL,'',0);
            setcookie(Authorization::KEY_PASSWORD,'',0);
                        
			?>
		<script>
		window.location = 'index.php';
		</script>
			<?PHP
		BREAK;
		}
	}

}
?>