<?PHP
$MenuOutput->AddTexte('Menu','Titre');
$MenuOutput->br(2);
$MenuOutput->AddLink('index.php?Section=Display_Shift','Visualiser l\'horaire');
$MenuOutput->br();
$MenuOutput->AddLink('index.php?Section=DateLookUp','Rechercher une date');
$MenuOutput->br();
$MenuOutput->AddLink('index.php?Section=Ajouter_Commentaire','Ajouter un commentaire');
$MenuOutput->br();
$MenuOutput->AddLink('index.php?Section=Modifier_Password','Modifier le mot de passe');
$MenuOutput->br(2);

$MenuOutput->AddLink('index.php?Action=Delog','Deconnexion');

echo $MenuOutput->Send(1);
?>