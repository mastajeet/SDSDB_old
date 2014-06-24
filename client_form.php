<?PHP
$MainOutput->addform('Ajouter / Modifier un client');
$MainOutput->inputhidden_env('Action','Client');
if(isset($_GET['IDClient'])){
	$Info = get_client_info($_GET['IDClient']);
	$MainOutput->inputhidden_env('IDClient',$_GET['IDClient']);
	$MainOutput->inputhidden_env('Update',TRUE);
}else{
	$Info = array('Nom'=>'','TXH'=>'0','Ferie'=>'1','Notes'=>'','DepotP'=>0,'Depot'=>'','Facturation'=>'_','FrequenceFacturation'=>'_','Email'=>'','Fax'=>'418','Tel'=>'418','Adresse'=>'','Cote'=>'','Actif'=>1,'Piece'=>0, 'RespF'=>'_','RespP'=>'_');
	$MainOutput->inputhidden_env('Update',FALSE);
}
$Facturation = array('F'=>'Fax','E'=>'Email');
$Frequence = array('H'=>'Hebdomadaire','M'=>'Mensuel');

$Responsable = "SELECT IDResponsable, Nom, Prenom FROM responsable ORDER BY Nom ASC";
$MainOutput->inputtext('Nom','Société','28',$Info['Nom']);
$MainOutput->inputtext('Cote','Cote','3',$Info['Cote']);
$MainOutput->inputphone('Tel','Téléphone',$Info['Tel']);
$MainOutput->textarea('Adresse','Adresse','25','5',$Info['Adresse']);
$MainOutput->textarea('Notes','Notes','25','5',$Info['Notes']);
$MainOutput->inputphone('Fax','Télécopieur',$Info['Fax']);
$MainOutput->inputtext('Email','Courriel','28',$Info['Email']);
$MainOutput->inputselect('Facturation',$Facturation,$Info['Facturation'],NULL);
$MainOutput->inputselect('FrequenceFacturation',$Frequence,$Info['FrequenceFacturation'],'Fréquence');
$MainOutput->inputtext('TXH','Taux Horaire','5',$Info['TXH']);
$MainOutput->inputtext('Ferie','Mod. Férié','1',$Info['Ferie']);
$MainOutput->inputtext('Depot','Dépot','4',$Info['Depot']);
$MainOutput->flag('DepotPaye',$Info['DepotP']);
$MainOutput->inputselect('RespP',$Responsable,$Info['RespP'],'ResponsableP');
$MainOutput->inputselect('RespF',$Responsable,$Info['RespF'],'ResponsableF');
$MainOutput->flag('Actif',$Info['Actif']);
$MainOutput->flag('Piece',$Info['Piece'],'Client à la pièce');

$MainOutput->formsubmit('Ajouter / Modifier');

echo $MainOutput->send(1);

?>
