<?PHP

if(isset($_POST['FORMGenerateCote']) and isset($_POST['FORMMois'])){

    $_POST['FORMCote'] = $_POST['FORMGenerateCote'];

    $month_to_bill = $_POST['FORMMois'];
    $cote_to_bill = $_POST['FORMCote'];
    $start_of_billing_time = new DateTime('now');
    $start_of_billing_time->setDate($start_of_billing_time->format('Y'),$month_to_bill,1);

    $customer = Customer::find_customer_by_cote($cote_to_bill);
    $factures = $customer->generate_factures($cote_to_bill, $start_of_billing_time);
    $nb_factures = count($factures);
    print($nb_factures." factures ont ete crees");
}else{
	
	$MainOutput->OpenTable();
	$MainOutput->OpenRow();
	$MainOutput->Opencol();
	
	$MainOutput->AddTexte('Facture mensuelle','Titre');
 	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	$SQL = new SQLclass();
	$Req = "SELECT Nom, Cote FROM client WHERE FrequenceFacturation = 'M'";
	$SQL->SELECT($Req); 
	$Installation = array();
	while($Rep = $SQL->FetchArray()){
		$Installation[$Rep[1]] = $Rep[0]; 
	}
    $now = new DateTime('now');
	$MainOutput->OpenRow();
	$MainOutput->Opencol();
		$MainOutput->addform('Ajouter une facture');
		$MainOutput->inputhidden_env('Section','Generate_Facture_Mensuelle');
        $MainOutput->inputselect('Mois',ConstantArray::get_month_kvp(),$now->format('m')-1, "Facturer le mois de:");
        $MainOutput->InputRadio('GenerateCote',$Installation,'','Piscine','VER');
		$MainOutput->formsubmit('Créer');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->CloseTable();
	
	
	
}
	
echo $MainOutput->send(1);
