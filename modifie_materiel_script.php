<?PHP
$SQL = new SQLclass();
$List = array('FORMNBForfait','FORMPrixForfait','FORMPrix1');

foreach($List as $v){
	if($_POST[$v]=="")
		$_POST[$v]="NULL";
}

	$Req = "UPDATE item SET
	`Description`='".addslashes($_POST['FORMDescription'])."',
	`Prix1`=".$_POST['FORMPrix1'].",
	`NBForfait`=".$_POST['FORMNBForfait'].",
	`PrixForfait`=".$_POST['FORMPrixForfait'].",
	`Fournisseur`='".addslashes($_POST['FORMFournisseur'])."' WHERE 
	IDItem = '".$_POST['IDItem']."'";
	$SQL->insert($Req);
	
$_GET['Section'] = "Display_Materiel";
?>