<?php

function renderCSVListEmployeeSummary($employee_dto_list){
    $header = "nom,prenom,telephone\n";
    $content = "";
    foreach($employee_dto_list as $employe)
    {
        $formatted_telephone_number = formatTelephoneNumber($employe["cellphone_number"]);
        $content .= $employe["nom"].",".$employe["prenom"].",".$formatted_telephone_number."\n";
    }

    return $header.$content;
}

function formatTelephoneNumber($telephone_number)
{
    $formatted_telephone_number = "(";
    $formatted_telephone_number .= substr($telephone_number,0,3);
    $formatted_telephone_number .= ") ";
    $formatted_telephone_number .= substr($telephone_number,3,3);
    $formatted_telephone_number .= "-";
    $formatted_telephone_number .= substr($telephone_number,6,4);

    return $formatted_telephone_number;
}

