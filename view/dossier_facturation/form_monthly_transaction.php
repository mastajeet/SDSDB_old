<?php
const YEAR = "Année";
const MONTH = "Mois";
const GENERATE_MONTHLY_TRANSACTIONS = "Générer le rapport des transactions mensuelles";
$MainOutput->addform(GENERATE_MONTHLY_TRANSACTIONS,'index.php','GET');
$MainOutput->inputhidden_env('Section','DossierFacturation_DisplayMonthlyTransactions');
$MainOutput->inputtext('month', MONTH,4, $month);
$MainOutput->inputtext('year', YEAR,4, $year);
$MainOutput->formsubmit('Générer');
print($MainOutput->send());