<?PHP
$SQL = new sqlclass();
$Req = "UPDATE remplacement SET Confirme = 1 WHERE IDRemplacement = ".$_GET['IDRemplacement'];
$SQL->QUERY($Req);

?>