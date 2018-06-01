<?php

if($authorization->verifySuperAdmin($_COOKIE)){
    $employee_bureau = Employee::find_by("Status","Bureau", "ORDER BY Nom ASC");

    $MainOutput->opentable();
    $MainOutput->openrow();

    $MainOutput->opencol('1%');
    $MainOutput->addpic('carlos.gif', "width=10, heigth=10");
    $MainOutput->closecol();

    $MainOutput->opencol();
    $MainOutput->addtexte("ID", "Titre");
    $MainOutput->closecol();

    $MainOutput->opencol();
    $MainOutput->addtexte("Nom","Titre");
    $MainOutput->closecol();

    $MainOutput->opencol();
    $MainOutput->addtexte("Prenom","Titre");
    $MainOutput->closecol();

    $MainOutput->closerow();

    foreach($employee_bureau as $current_employee_bureau){

        $MainOutput->openrow();

        $MainOutput->opencol();
        $MainOutput->addlink('index.php?Section=Modifie_Employe&IDEmploye='.$current_employee_bureau->IDEmploye,'<img src=b_edit.png border=0>');
        $MainOutput->closecol();

        $MainOutput->opencol();
        $MainOutput->addtexte($current_employee_bureau->IDEmploye);
        $MainOutput->closecol();

        $MainOutput->opencol();
        $MainOutput->addtexte($current_employee_bureau->Nom);
        $MainOutput->closecol();

        $MainOutput->opencol();
        $MainOutput->addtexte($current_employee_bureau->Prenom);
        $MainOutput->closecol();

        $MainOutput->closerow();
    }

    echo $MainOutput->send(1);
}