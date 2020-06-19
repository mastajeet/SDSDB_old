<?php
const GENERATE_INTEREST_FACTURE = "Générer une invoice d'intérêt";
const GENERATE = "Générer";

$MainOutput->addform(GENERATE_INTEREST_FACTURE);
$MainOutput->inputhidden_env('Section','Genrate_Facture_Interest');
foreach($unpaid_factures as $facture){

    $formated_date = date("d-m-Y", $facture->EnDate);
    $facture_total = $facture->STotal *(1+$facture->TPS)*(1+$facture->TVQ);
    $formated_facture_total = number_format($facture_total, 2,'.', ' ')." $";
    $choice_string = "<b>".$facture->Cote."-".$facture->Sequence."</b> ".$formated_facture_total." \n (".$formated_date.")";

    $MainOutput->flag('IDFacture['.$facture->IDFacture.']', '1',$choice_string);
    $MainOutput->br();

}
$MainOutput->inputtext('InterestRate','taux intérêt (%)',2);
$MainOutput->inputtime('StartDate','Date début',Null,array('Time'=>false, 'Date'=>true) );
//$MainOutput->flag
$MainOutput->formsubmit(GENERATE);
print($MainOutput->send(1));
