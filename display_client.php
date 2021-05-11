<?PHP
if(!isset($_POST['FORMIDClient'])){
	$MainOutput->addform('Afficher un client');
	$MainOutput->inputhidden_env('Section','Display_Client');
	$Req = "SELECT IDClient, Nom FROM client ORDER BY Nom ASC";
	$MainOutput->inputselect('IDClient',$Req,'Client');
	$MainOutput->formsubmit('Afficher');
	echo $MainOutput->send(1);
}else{
    $customer = new Customer($_POST['FORMIDClient']);
    $MainOutput->AddOutput(format_client($_POST['FORMIDClient']),0,0);
	$Installations = $customer->get_installations();
		foreach($Installations as $installation){
		    if ($installation->Actif)
		    {
                $MainOutput->OpenTable(500);
                $MainOutput->Openrow();
                $MainOutput->OpenCol();
                $MainOutput->addtexte("-------------------------------------------------------------------------------------------------------------");
                $MainOutput->CloseCol();
                $MainOutput->CloseRow();
                $MainOutput->CloseTable();
                include('view/installation/display_installation_information.php');
            }
        }

	echo $MainOutput->send(1);
}
?>