<?PHP
if(isset($_GET['IDInspection'])){
	$INFO = get_info('inspection',$_GET['IDInspection']);
	$MainOutput->AddForm('Faire le suivi d\'une inspection');

	$MainOutput->InputHidden_Env('Action','SuiviInspection');
	$MainOutput->InputHidden_Env('IDInspection',$_GET['IDInspection']);
	
	$MainOutput->Flag('Envoye',$INFO['Envoye'],'Rapport&nbsp;d\'inspection&nbsp;envoyé&nbsp;au&nbsp;responsable');
	$MainOutput->Flag('Confirme',$INFO['Confirme'],'La réception du rapport à été confirmée avec le responsable');

	$Radio = array('Non Repondu'=>0,'Ne désire pas de matériel'=>'-1','Désire le matériel'=>'1');
	$MainOutput->InputRadio('Materiel',$Radio,$INFO['Materiel'],'Le client:');
	$MainOutput->Flag('MaterielPret',$INFO['MaterielPret'],'La commande de matériel est montéee');
	$MainOutput->Flag('MaterielLivre',$INFO['MaterielLivre'],'La commande de matériel est livrée');
	$MainOutput->TextArea('Notes',NULL,45,5,$INFO['Notes']);
	$MainOutput->FormSubmit('Faire le suivi');
}
echo $MainOutput->Send(1);
?>