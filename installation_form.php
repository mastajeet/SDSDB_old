<?PHP
$MainOutput->addform('Ajouter / Modifier une installation');
	$MainOutput->inputhidden_env('Action', 'Installation');

if(isset($_GET['IDInstallation'])){
	$Info = get_installation_info($_GET['IDInstallation']);
	$MainOutput->inputhidden_env('Update',TRUE);
	$MainOutput->inputhidden_env('IDInstallation',$_GET['IDInstallation']);
	$MainOutput->inputhidden_env('FORMIDClient',$Info['IDClient']);
}else{
	$MainOutput->inputhidden_env('Update',FALSE);
	$MainOutput->inputhidden_env('FORMIDClient',$_GET['IDClient']);
	$Info = array('Nom'=>'','Punch'=>'0','Cadenas'=>'0','Assistant'=>'0','Cote'=>'','IDSecteur'=>'','IDHoraire'=>'','IDType'=>'','IDResponsable'=>'','Adresse'=>'','Tel'=>'418','Note'=>'','Lien'=>'','Notes'=>'','IDClient'=>$_GET['IDClient'],'IDResponsable'=>'','Actif'=>1,'Toilettes'=>'','ASFact'=>'','AdresseFact'=>'','PONo'=>'');
}
if(isset($FORMIDClient))
$Info['IDClient'] = $FORMIDClient;
$Req = "SELECT IDClient, Nom FROM client WHERE Actif ORDER BY Nom ASC";
$Responsable = "SELECT IDResponsable, Nom, Prenom FROM responsable ORDER BY Nom ASC";
$Type = array('I'=>'Intérieure','IS'=>'Intérieure + Spa','E'=>'Extérieure','ES'=>'Extérieure + Spa','EP'=>'Extérieure + Patogeoire','P'=>'Plage');


$MainOutput->inputtext('Cote','Cote','3',$Info['Cote']);
$MainOutput->inputtext('Nom','Emplacement','28',$Info['Nom']);
$MainOutput->inputselect('IDType',$Type,$Info['IDType'],'Type d\'installation');
$MainOutput->inputselect('IDResponsable',$Responsable,$Info['IDResponsable'],'Répondant');
$MainOutput->inputphone('Tel','Téléphone de la piscine',$Info['Tel'],1);
$MainOutput->textarea('Adresse','Adresse','25','4',$Info['Adresse']);
$MainOutput->inputtext('ASFact','Facture au soin de','28',$Info['ASFact']);
$MainOutput->textarea('AdresseFact','Adresse de facturation','25','4',$Info['AdresseFact']);
$MainOutput->inputtext('PONo','Numero PO','28',$Info['PONo']);


$Secteur = "SELECT IDSecteur, Nom FROM secteur ORDER BY Nom ASC";
$MainOutput->inputselect('IDSecteur',$Secteur,$Info['IDSecteur'],'Secteur');
$MainOutput->textarea('Toilettes','Toilettes','25','2',$Info['Toilettes']);
$MainOutput->textarea('Notes','Notes','25','2',$Info['Notes']);
$MainOutput->inputtext('Lien','Lien','28',$Info['Lien']);
$MainOutput->flag('Punch',$Info['Punch']);
$MainOutput->flag('Assistant',$Info['Assistant']);
$MainOutput->flag('Cadenas',$Info['Cadenas']);
$MainOutput->flag('Actif',$Info['Actif']);


$MainOutput->formsubmit('Ajouter / Modifier');
echo $MainOutput->send(1);

?>
