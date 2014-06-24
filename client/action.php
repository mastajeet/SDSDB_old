<?PHP
if(isset($_GET['Action'])){
	if($_GET['Action']=="Delog")
		$_POST['Action']=$_GET['Action'];
}

if(isset($_POST['Action'])){

	switch($_POST['Action']){
	
		CASE "Ajouter_Commentaire":{
			include('script_ajoutercommentaire.php');
			BREAK;
		}
	
		CASE "Date_Lookup":{
			include('../date_lookup_script.php');
			BREAK;
		}
		
		case "Login":{
			include('script_login.php');
			BREAK;
		}
		
		case "Delog":{
			setcookie('IDClient','',0);
			setcookie('CIE','',0);
			?><script>
			window.location = 'index.php'
			</script>
			<?PHP
			BREAK;
		}
		
		case "Modifier_Password":{
			include('script_newpass.php');
			BREAK;
		}
	}

}

?>