<?PHP
$MainOutput->addform('Ajouter / Modifier une installation');
	$MainOutput->inputhidden_env('Action', 'Installation');

if(isset($_GET['IDInstallation'])){
	$info = new Installation($_GET['IDInstallation']);
	$MainOutput->inputhidden_env('Update',TRUE);
	$MainOutput->inputhidden_env('IDInstallation',$_GET['IDInstallation']);
	$MainOutput->inputhidden_env('IDClient',$info->IDClient);

}else{
	$MainOutput->inputhidden_env('Update',FALSE);
	$MainOutput->inputhidden_env('IDClient',$_GET['IDClient']);
	$info = new Installation();
}


$responsables = Responsable::get_all(1, 'Nom', 'ASC');
$secteurs = Secteur::get_all(1,"Nom", "ASC");

$installation_type = ConstantArray::get_installation_type_kvp();
$installation_parking_type = ConstantArray::get_installation_parking_type_kvp();

$MainOutput->inputtext('Cote','Cote','3',$info->Cote);
$MainOutput->inputtext('Nom','Emplacement','28',$info->Nom);
$MainOutput->inputselect('IDType',$installation_type,$info->IDType,'Type d\'installation');
$MainOutput->inputselect('IDResponsable',ModelToKVPConverter::to_kvp($responsables, "IDResponsable", "full_name"),$info->IDResponsable,'R�pondant');
$MainOutput->inputphone('Tel','T�l�phone de la piscine',$info->Tel,1);
$MainOutput->textarea('Adresse','Adresse','25','4',$info->Adresse);
$MainOutput->inputtext('ASFact','Facture au soin de','28',$info->ASFact);
$MainOutput->textarea('AdresseFact','Adresse de facturation','25','4',$info->AdresseFact);
$MainOutput->inputtext('PONo','Numero PO','28',$info->PONo);


$MainOutput->inputselect('IDSecteur',ModelToKVPConverter::to_kvp($secteurs, "IDSecteur", "Nom"),$info->IDSecteur,'Secteur');
$MainOutput->textarea('Toilettes','Toilettes','25','2',$info->Toilettes);
$MainOutput->textarea('Notes','Notes','25','2',$info->Notes);
$MainOutput->inputtext('Lien','Lien','28',$info->Lien);
$MainOutput->inputselect("Stationnement", $installation_parking_type, $info->Stationnement);
$MainOutput->flag('Punch',$info->Punch);
$MainOutput->flag('Assistant',$info->Assistant);
$MainOutput->flag('Cadenas',$info->Cadenas);
$MainOutput->flag('Actif',$info->Actif);


$MainOutput->formsubmit('Ajouter / Modifier');
echo $MainOutput->send(1);

?>
