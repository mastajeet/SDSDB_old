<?php

    //$installation variable is passed by controller

    $Info = get_installation_info($installation->IDInstallation);
    $SQL = new sqlclass();
    
    $MainOutput->opentable('500');
    $MainOutput->openrow();
    $MainOutput->opencol('100%',2);
    $MainOutput->AddLink($installation->Lien,$installation->Nom,"_BLANK",'Titre');
    $MainOutput->AddTexte("&nbsp; (".$installation->Cote.")",'Titre');
    $MainOutput->AddLink('index.php?Section=Installation_Form&IDInstallation='.$installation->IDInstallation,'<img src=assets/buttons/b_edit.png border=0>');
    $MainOutput->AddLink('index.php?Section=Horshift&IDInstallation='.$installation->IDInstallation,'<img src=assets/buttons/b_save.png border=0>');

    if($authorization->verifySuperAdmin($_COOKIE)){
        $MainOutput->AddLink('index.php?Cote='.$installation->Cote,'<img src=assets/buttons/b_fact.png border=0>');
    }
    $MainOutput->AddLink('index.php?Section=ClientComment_Form&IDInstallation='.$installation->IDInstallation,'<img src=assets/buttons/b_conf.png border=0>');
    $MainOutput->closecol();
    $MainOutput->closerow();


    $MainOutput->openrow();
    $MainOutput->opencol();
    $MainOutput->AddTexte("Type: ".array_get(ConstantArray::get_installation_type_kvp()[$installation->IDType])."
		Punch: ".get_flag($installation->Punch)."
		Assistant: ".get_flag($installation->Assistant)."
		Cadenas SdS: ".get_flag($installation->Cadenas),'Texte');
    $MainOutput->closecol();
    $MainOutput->opencol();
    $MainOutput->AddTexte("Dernière Inspection: à  venir"."
    Stationnement: ". array_get(ConstantArray::get_installation_parking_type_kvp()[$installation->Stationnement]));
    $MainOutput->br();

    $MainOutput->closecol();
    $MainOutput->closerow();
    $MainOutput->Openrow();
    $MainOutput->OpenCol('50%');
    $MainOutput->addoutput(format_responsable($installation->IDResponsable,'de la piscine',$installation->IDClient),0,0);
    $MainOutput->closecol();
    $MainOutput->OpenCol('50%');
    $MainOutput->AddTexte('Adresse de la piscine','Titre');
    $MainOutput->br();
    $MainOutput->AddTexte($installation->Adresse);
    if(strlen($installation->Tel)>4){
        $MainOutput->br();
        $MainOutput->AddTexte("Tel.: (".substr($installation->Tel,0,3).") ".substr($installation->Tel,3,3)."-".substr($installation->Tel,6,4));
        if(strlen(substr($installation->Tel,10,4))>1)
            $MainOutput->AddTexte(" #".substr($installation->Tel,10,4));
    }
    $MainOutput->closecol();
    $MainOutput->closerow();
    if($installation->Notes<>""){
        $MainOutput->openrow();
        $MainOutput->opencol('100%',2);
        $MainOutput->AddTexte("Notes: ".$installation->Notes,'Texte');
        $MainOutput->closecol();
        $MainOutput->closerow();
    }
    if($installation->Toilettes<>""){
        $MainOutput->openrow();
        $MainOutput->opencol('100%',2);
        $MainOutput->AddTexte("Toilettes: ".$installation->Toilettes,'Texte');
        $MainOutput->closecol();
        $MainOutput->closerow();
    }


    $MainOutput->CloseTable();

