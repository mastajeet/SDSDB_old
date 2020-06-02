<?PHP
$SQL = new sqlclass;
$Start = mktime(0,0,0,$_POST['FORMStart4'],$_POST['FORMStart5'],$_POST['FORMStart3']);
if($_POST['FORMEnd5']==""){
	$End = $Start+7*24*60*60;
}else{
$End = mktime(0,0,0,$_POST['FORMEnd4'],$_POST['FORMEnd5'],$_POST['FORMEnd3']);
}
$Req = "INSERT INTO message(`Start`,`End`,`Titre`,`Texte`,`IDEmploye`) VALUES('".$Start."','".$End."','".addslashes($_POST['FORMTitre'])."','".addslashes($_POST['FORMTexte'])."','".$_POST['FORMIDEmploye']."')";
$SQL->INSERT($Req);
?>