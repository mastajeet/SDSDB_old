<?PHP
$SQL = new SQLclass();

$List = array('FORMNBForfait','FORMPrixForfait','FORMPrix1');

foreach($List as $v){
	if($_POST[$v]=="")
		$_POST[$v]="NULL";
}


$Req = "INSERT INTO item(`Description`,`Prix1`,`NBForfait`,`PrixForfait`,`Fournisseur`) VALUES
(
'".addslashes($_POST['FORMDescription'])."',
".$_POST['FORMPrix1'].",
".$_POST['FORMNBForfait'].",
".$_POST['FORMPrixForfait'].",
'".$_POST['FORMFournisseur']."')";


$SQL->insert($Req);
$_GET['Section'] = "Display_Materiel";


?>