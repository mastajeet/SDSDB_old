<?PHP
$MainOutput->addform('Ajouter / Modifier le matériel en vente');
$MainOutput->inputhidden_env('Action','Materiel');
if(isset($_GET['IDItem'])){
	$Info = get_materiel_info($_GET['IDItem']);
	$MainOutput->inputhidden_env('IDItem',$_GET['IDItem']);
	$MainOutput->inputhidden_env('Update',TRUE);
}else{
	$Info = array('Description'=>'','Prix1'=>'','NBForfait'=>'','PrixForfait'=>'','Fournisseur'=>'','Actif'=>1);
	$MainOutput->inputhidden_env('Update',FALSE);
}
$MainOutput->inputtext('Description','Description','28',$Info['Description']);

$Fournisseur = array('Secourisme PME'=>'Secourisme PME','AQUAM'=>'AQUAM','Croix-Rouge'=>'Croix-Rouge');
$MainOutput->inputselect('Fournisseur',$Fournisseur,$Info['Fournisseur'],'Fournisseur');

$MainOutput->inputtext('Prix1','Prix unitaire','4',$Info['Prix1']);
$MainOutput->inputtext('NBForfait','Nombre par forfait','4',$Info['NBForfait']);
$MainOutput->inputtext('PrixForfait','Prix du forfait','4',$Info['PrixForfait']);


$MainOutput->formsubmit('Ajouter / Modifier');

echo $MainOutput->send(1);

?>
