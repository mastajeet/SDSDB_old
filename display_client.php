<?PHP
if(!isset($_POST['FORMIDClient'])){
	$MainOutput->addform('Afficher un client');
	$MainOutput->inputhidden_env('Section','Display_Client');
	$Req = "SELECT IDClient, Nom FROM client ORDER BY Nom ASC";
	$MainOutput->inputselect('IDClient',$Req,'Client');
	$MainOutput->formsubmit('Afficher');
	echo $MainOutput->send(1);
}else{
	$MainOutput->AddOutput(format_client($_POST['FORMIDClient']),0,0);
	$Installations = get_installations($_POST['FORMIDClient']);
		foreach($Installations as $v){
			$MainOutput->OpenTable(500);
		$MainOutput->Openrow();
		$MainOutput->OpenCol();
			$MainOutput->addtexte("-------------------------------------------------------------------------------------------------------------");
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		$MainOutput->CloseTable();
			$MainOutput->AddOutput(format_installation($v),0,0);
		}
	echo $MainOutput->send(1);
}
?>