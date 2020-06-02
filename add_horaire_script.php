<?PHP
$SQL = new sqlclass();
$Req = "INSERT INTO horaire(`Nom`) 

VALUES(
'".addslashes($_POST['FORMNom'])."')";
$SQL->insert($Req);
?>