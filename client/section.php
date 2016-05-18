<?PHP
switch($_GET['Section']){

	CASE "Display_Shift":{
		include('displayhoraire.php');
		BREAK;
	}
	
	CASE "Ajouter_Commentaire":{
		include('form_ajoutercommentaire.php');
		BREAK;
	}
	
	Case "DateLookUp":{
		include('../datelookup_form.php');
		BREAK;
	}
	
	Case "Modifier_Password":{
		include('form_newpass.php');
		BREAK;
	}
	
}
echo $MainOutput->send(1);

?>