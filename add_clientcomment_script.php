<?PHP
$TO = mktime(0,0,0,$_POST['FORMDate4'],$_POST['FORMDate5'],$_POST['FORMDate3']);
$Req = "INSERT INTO clientrapport(`IDInstallation`,`IDResponsable`,`Date`,`Comment`,`ToImprove`,`BeenImproved`) VALUES(".$_POST['FORMIDInstallation'].",".$_POST['FORMIDResponsable'].",".$TO.",'".addslashes($_POST['FORMComment'])."','".addslashes($_POST['FORMToImprove'])."','".addslashes($_POST['FORMBeenImproved'])."')";
$SQL = new sqlclass;
$SQL->INSERT($Req);
?>