<?PHP

$ItemList = Array('Envoye','Confirme','Materiel','MaterielPret','MaterielLivre');
foreach($ItemList as $k){
	if(!isset($_POST['FORM'.$k]) OR $_POST['FORM'.$k]=="")
	$_POST['FORM'.$k]=0;
}

$Req = "UPDATE inspection SET Envoye = ".$_POST['FORMEnvoye'].", Confirme = ".$_POST['FORMConfirme'].", Materiel = ".$_POST['FORMMateriel'].", MaterielPret = ".$_POST['FORMMaterielPret'].", MaterielLivre = ".$_POST['FORMMaterielLivre']." WHERE IDInspection = ".$_POST['IDInspection'];
$SQL->QUERY($Req);

$_GET['Section'] = "Inspection";
?>