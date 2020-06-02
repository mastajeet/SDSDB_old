<?php

const GET_FREE_EMPLOYEE_LIST = "Liste d'employés disponibles";


$MainOutput->addtexte(GET_FREE_EMPLOYEE_LIST, 'titre');
$MainOutput->opentable("60%");

$MainOutput->openrow();
$MainOutput->opencol();
$MainOutput->addtexte("Nom",'titre');
$MainOutput->closecol();
$MainOutput->opencol();
$MainOutput->addtexte("Telephone",'titre');
$MainOutput->closecol();
$MainOutput->opencol();
$MainOutput->addtexte("Cellulaire",'titre');
$MainOutput->closecol();

$MainOutput->closerow();

foreach($free_employees as $employee){
    $MainOutput->openrow();
    $MainOutput->opencol();
    $MainOutput->addlink("index.php?Section=Employe&IDEmploye={$employee->IDEmploye}","{$employee->Nom} {$employee->Prenom}");
    $MainOutput->closecol();

    $MainOutput->opencol();
    $MainOutput->addphone($employee->TelP);

    $MainOutput->closecol();
    $MainOutput->opencol();
    $MainOutput->addphone($employee->Cell);
    $MainOutput->closecol();
    $MainOutput->closerow();
}
$MainOutput->closetable();

echo $MainOutput->send(1);
