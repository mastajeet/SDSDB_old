<?PHP

if(isset($_REQUEST['Section'])){

	SWITCH($_REQUEST['Section']){

	
		CASE "Info":{
				include('staff/info.php');
		BREAK;
		}
		CASE "Horaire":{
				include('staff/horaire.php');
		BREAK;
		}
		CASE "Confirm_Heures":{
				include('staff/confirm_heures_form.php');
		BREAK;
		}
		
		CASE "Test":{
				include('staff/test.php');
		BREAK;
		}
		CASE "Welcome":{
				include('staff/message.php');
		BREAK;
		}
	}

}
?>