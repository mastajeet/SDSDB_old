<?PHP
const AJOUTER_UNE_FACTURE = 'Ajouter une facture';
const CREER = 'Creer';
const ALREADY_BILLED = 'La facture pour cette période est déjà faite ou rien n\'est à facturer';
const INCOMPLETE_PERIOD = 'Vous ne pouvez pas faire la facturation pour une période non complétée';
const HOLIDAY = " Journée Fériée";
const SECOND_LIFEGUARD = "Deuxième Sauveteur";
const FIRST_LIFEGUARD = "Sauveteur";

if(isset($_GET['Semaine']) && !isset($_POST['FORMGenerateCote'])){
	$MainOutput->OpenTable();
	$MainOutput->OpenRow();
	$MainOutput->Opencol();
	$ENDS = get_end_dates(0,$_GET['Semaine']);
	$MainOutput->AddTexte('Semaine du '.$ENDS['Start'].' au '.$ENDS['End'],'Titre');
 	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

    $installation_to_bill = Installation::get_installations_in_string_to_bill($_GET['Semaine']);

	$MainOutput->OpenRow();
	$MainOutput->Opencol();
		$MainOutput->addform(AJOUTER_UNE_FACTURE);
		$MainOutput->inputhidden_env('Section','Generate_Facture');
		$MainOutput->inputhidden_env('Semaine',$_GET['Semaine']);
		$MainOutput->InputRadio('GenerateCote',$installation_to_bill,'','Piscine','VER');
		$MainOutput->formsubmit(CREER);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->CloseTable();
}elseif(isset($_POST['Semaine']) AND isset($_POST['FORMGenerateCote'])){
    $_POST['FORMCote'] = $_POST['FORMGenerateCote'];

    $installation_to_bill = Installation::get_installations_to_bill($_POST['FORMCote'], $_POST['Semaine']);
    if(count($installation_to_bill)==0){
        $MainOutput->AddTexte(ALREADY_BILLED,'Warning');
    }elseif($_POST['Semaine'] >= get_last_sunday(0,time()) ) {
        $MainOutput->AddTexte(INCOMPLETE_PERIOD, 'Warning');
    }else{


        $facture = Facture::generate_facture($_POST['FORMCote'],$_POST['Semaine']);


        $SQL = new SqlClass();
        $Req = "UPDATE shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation SET Facture=1 WHERE `Semaine`=".$_POST['Semaine']." AND Cote='".$_POST['FORMCote']."'";
        $SQL->Query($Req);
        $Modifie=TRUE;
        $_GET['IDFacture'] = $facture->IDFacture;
        $MainOutput->emptyoutput();
        $MainOutput->addoutput(include('display_facture.php'),0,0);
	}
	
}
echo $MainOutput->send();