<?PHP
$Piscine = "SELECT installation.IDInstallation, installation.Nom FROM horaire RIGHT JOIN installation on installation.IDHoraire = horaire.IDHoraire WHERE installation.IDHoraire <> 'NULL' ORDER BY installation.Nom ASC";
$SQL = new sqlclass;
$SQL->SELECT($Piscine);


$FROM = mktime(0,0,0,$_POST['FORMFROM4'],$_POST['FORMFROM5'],$_POST['FORMFROM3']);
$TO = mktime(0,0,0,$_POST['FORMTO4'],$_POST['FORMTO5'],$_POST['FORMTO3']);
while($Rep = $SQL->FetchArray()){
	if(isset($_POST['FORMIDInstallation'.$Rep[0]])){
		generate_shift($Rep[0],$FROM,$TO);
	}
}
$_GET['Section'] = "Display_Shift";
?>