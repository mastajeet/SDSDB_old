<?PHP
$SQL = new sqlclass();

if($_POST['FORMNom']==""){
	$Req = "DELETE FROM responsable WHERE IDResponsable = '$_POST[IDResponsable]'";
}else{

$Req = "UPDATE responsable SET 
`Titre` = '".$_POST['FORMTitre']."',
`Prenom` = '".$_POST['FORMPrenom']."',
`Nom` = '".$_POST['FORMNom']."',
`Tel`='".$_POST['FORMTel1'].$_POST['FORMTel2'].$_POST['FORMTel3'].$_POST['FORMTel4']."',
`Cell`='".$_POST['FORMCell1'].$_POST['FORMCell2'].$_POST['FORMCell3']."',
`Appartement`='".$_POST['FORMAppartement']."' WHERE IDResponsable = '$_POST[IDResponsable]'"; 
}

$SQL->update($Req);

?>

