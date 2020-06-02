<?php
const NO_SELECTED_COTE = 'Aucune cote n\'a été sélectionnée';
const BILLED_TO = 'Facturé à: ';
const BALANCE_TO_RECOVER = "<b>Solde du compte à recevoir: </b>";
const EFFECTIVE_DATE = "<b>En date du: </b>";
const TO_RECOVER = "<b>à recevoir</b>";
const DETAILS = "<b>Détail</b>";
const RECIEVED = "<b>Reçu</b>";
const BALANCE = "<b>Solde</b>";
const DATE = "<b>Date</b>";
const ANTERIOR_BALANCE = "<b>Solde Antérieur</b>";

// $customer_balance, shown_transactions, opening_balance, customer are passed by controler
$statement_generation_date = strftime(J_MMMM_YYYY,time());

$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('60%');

	$MainOutput->AddPic('logo.jpg');
	$MainOutput->br();
	$MainOutput->AddTexte('Installation(s): ','Titre');
	$MainOutput->AddTexte(get_installation_by_cote_in_string($_GET['Cote']));
	$MainOutput->br();
	$MainOutput->AddTexte('Cote: ','Titre');
	$MainOutput->AddTexte($customer->Cote);
	$MainOutput->br();

$MainOutput->CloseCol();
$MainOutput->OpenCol('40%');
    $MainOutput->AddTexte(BILLED_TO,'Titre');
    $MainOutput->AddTexte($customer->Nom);
    $MainOutput->br();
    $MainOutput->AddTexte('A/S: ','Titre');
    $MainOutput->AddTexte($customer->responsables['responsable_facturation']->full_name);
    $MainOutput->br();
    $MainOutput->AddTexte('Tel.: ','Titre');
    $telephone = $customer->Tel;
    $MainOutput->AddTexte("(".substr($telephone,0,3).") ".substr($telephone,3,3)."-".substr($telephone,6,4));
    if(strlen(substr($telephone,10,4))>1)
        $MainOutput->AddTexte(" #".substr($telephone,10,4));
    $MainOutput->br();
    $MainOutput->AddTexte($customer->Adresse);
    $MainOutput->br();
    if($customer->Facturation=="E"){
        $MainOutput->AddTexte('Email: ','Titre');
        $MainOutput->AddTexte($customer->Email);
    }
    if($customer->Facturation=="F"){
        $fax = $customer->Fax;
        $MainOutput->AddTexte("<b>Fax.</b>: (".substr($fax ,0,3).") ".substr($fax ,3,3)."-".substr($fax ,6,4));
    }
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->CloseTable();

$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%');
    $MainOutput->AddTexte(EFFECTIVE_DATE .$statement_generation_date);
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%');
    $MainOutput->AddTexte(BALANCE_TO_RECOVER .number_format($customer_balance['balance'],2)." $");
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%');
    $MainOutput->AddTexte("");
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->CloseTable();

$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('20%');
    $MainOutput->AddTexte(DATE);
$MainOutput->CloseCol();
$MainOutput->OpenCol('35%');
    $MainOutput->AddTexte(DETAILS);
$MainOutput->CloseCol();
$MainOutput->OpenCol('10%');
    $MainOutput->AddTexte(TO_RECOVER);
$MainOutput->CloseCol();

$MainOutput->OpenCol('10%');
    $MainOutput->AddTexte(RECIEVED);
$MainOutput->CloseCol();

$MainOutput->OpenCol('10%');
    $MainOutput->AddTexte(BALANCE);
$MainOutput->CloseCol();
$MainOutput->CloseRow();

if($opening_balance>0){
    $MainOutput->OpenRow();
    $MainOutput->OpenCol('',5);
        $MainOutput->AddTexte("<br>");
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();
        $MainOutput->OpenRow();
    $MainOutput->OpenCol('',3);
        $MainOutput->AddTexte(ANTERIOR_BALANCE);
    $MainOutput->CloseCol();
    $MainOutput->OpenCol();
        $MainOutput->AddTexte("");
    $MainOutput->CloseCol();
    $MainOutput->OpenCol();
        $MainOutput->AddTexte(number_format($opening_balance,2)." $");
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();
    $MainOutput->OpenRow();
    $MainOutput->OpenCol('',5);
        $MainOutput->AddTexte("<br>");
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();
}

foreach($shown_transactions as $transaction){
    $MainOutput->OpenRow();

    $MainOutput->OpenCol();
        $MainOutput->AddTexte(strftime(J_MMM_YY, $transaction['date']->getTimestamp()));
    $MainOutput->CloseCol();
    $MainOutput->OpenCol();
        $MainOutput->AddTexte($transaction['notes']);
    $MainOutput->CloseCol();
    $MainOutput->OpenCol();
    if($transaction['debit']<>""){
        $MainOutput->AddTexte(number_format($transaction['debit'],2)." $");
    }
    $MainOutput->CloseCol();

    $MainOutput->OpenCol();
    if($transaction['credit']<>""){
        $MainOutput->AddTexte(number_format($transaction['credit'],2)." $");
    }
    $MainOutput->CloseCol();

    $MainOutput->OpenCol();
            $MainOutput->AddTexte(number_format($transaction['balance'],2)." $");
    $MainOutput->CloseCol();

    $MainOutput->CloseRow();
}

echo $MainOutput->Send(1);
?>
