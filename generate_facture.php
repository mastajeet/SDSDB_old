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

        $customer = customer::find_customer_by_cote($_POST['FORMCote']);


        foreach($installation_to_bill as $installation){

            $shifts = Shift::find_billable_shift_by_installation($installation->IDInstallation,$_POST['Semaine']);
            $i =0;
            $Shift_to_bill = array();
            foreach($shifts as $Rep){
                $Titre = FIRST_LIFEGUARD;
                if($Rep->is_shift_assistant()) {
                    $Titre = SECOND_LIFEGUARD;
                }
                if(isset($last_shift) and $Rep->is_connected_after($last_shift)){
                    $Shift_to_bill[$i-1]['End'] = $Rep->End;
                    $Shift_to_bill[$i-1]['Notes'] = substr($Shift_to_bill[$i-1]['Notes'],0,-1);
                    $Shift_to_bill[$i-1]['Notes'] .= "-".get_employe_initials($Rep->IDEmploye).")";
                }else{
                    $Shift_to_bill[$i] = array('Start'=>$Rep->Start,'End'=>$Rep->End,'Jour'=>$Rep->Jour,'TXH'=>$Rep->TXH,'Notes'=>$Titre.": ".$installation->Nom." (".get_employe_initials($Rep->IDEmploye).")",'Ferie'=>$customer->Ferie);
                    $i++;
                }
                $last_shift = $Rep;
            }
            $IDFacture = add_facture($_POST['FORMCote'],$_POST['Semaine']);

            foreach($Shift_to_bill as $v){

                $v['End'] = $v['End'] - bcmod($v['End'],36);
                $v['Start'] = $v['Start'] - bcmod($v['Start'],36);

                if($v['Start']==0 and $v['End']==14400)
                    $v['Notes'] = $v['Notes']." (Minimum 4h)";

                if(is_ferie($v['Jour']*86400+$_POST['Semaine'])){
                    if($v['Ferie']<>1){
                        $v['TXH'] = $v['TXH']*$v['Ferie'];
                        $v['Notes'] = $v['Notes']." (x".$v['Ferie']. HOLIDAY.")";
                    }
                }
                $Req = "INSERT INTO factsheet(`IDFacture`,`Start`,`End`,`Jour`,`TXH`,`Notes`) VALUES(".$IDFacture.",'".$v['Start']."','".$v['End']."','".$v['Jour']."','".$v['TXH']."','".addslashes($v['Notes'])."')";


                $SQL = new sqlclass;
                $SQL2 = new sqlclass;
                $SQLins = new sqlclass();
                $SQL->Insert($Req);
            }
            update_facture_balance($IDFacture);
        }

        $Req = "UPDATE shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation SET Facture=1 WHERE `Semaine`=".$_POST['Semaine']." AND Cote='".$_POST['FORMCote']."'";
        $SQL->Query($Req);
        $Modifie=TRUE;
        $_GET['IDFacture'] = $IDFacture;
        $MainOutput->emptyoutput();
        $MainOutput->addoutput(include('display_facture.php'),0,0);
	}
	
}
echo $MainOutput->send(1);