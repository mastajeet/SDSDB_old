<?PHP
$SQL = new sqlclass();
$Req = "INSERT INTO responsable(`Titre`,`Prenom`,`Nom`,`Tel`,`Cell`,`Appartement`) 

VALUES(
'".$_POST['FORMTitre']."',
'".$_POST['FORMPrenom']."',
'".$_POST['FORMNom']."',
'".$_POST['FORMTel1'].$_POST['FORMTel2'].$_POST['FORMTel3'].$_POST['FORMTel4']."',
'".$_POST['FORMCell1'].$_POST['FORMCell2'].$_POST['FORMCell3']."',
'".$_POST['FORMAppartement']."')";
$SQL->insert($Req);
?>