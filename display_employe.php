<?php
$Info = get_employe_info($_GET['IDEmploye']);

$MainOutput->addlink('index.php?Section=Modifie_Employe&IDEmploye='.$Info['IDEmploye'],'<img src=b_edit.png border=0>');
$MainOutput->addlink('index.php?Section=Employe_Horshift&IDEmploye='.$Info['IDEmploye'],'<img src=b_fact.png border=0>');
$MainOutput->addlink('index.php?Section=Employe_Report&IDEmploye='.$Info['IDEmploye'].'&ToPrint=TRUE','<img src=b_sheet.png border=0>');
$MainOutput->addlink('index.php?Section=Employe_Horshift&IDEmploye='.$Info['IDEmploye'],'<img src=b_fact.png border=0>');
$MainOutput->addlink('index.php?Section=Display_AskedRemplacement&IDEmploye='.$Info['IDEmploye'],'<img src=b_del.png border=0>');



$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Personnel------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->addtitledoutput($title='Numero Employe', $string = $Info['IDEmploye']);

$MainOutput->addtitledoutput('Nom',$string=$Info['Nom']);
$MainOutput->addtitledoutput('Prenom',$Info['Prenom']);
$MainOutput->addtitledoutput('Nom Horaire',$Info['HName']);
$MainOutput->addtitledoutput('Date Naissance', datetostr($Info['DateNaissance']));
$MainOutput->addtitledoutput('Numéro d\'assurance sociale', $Info['NAS']);
$MainOutput->addtitledoutput('Notes',$Info['Notes']);
$MainOutput->CloseCol();
$MainOutput->CloseRow(); 


//check s'il y a des vacances à venir
$Req = "SELECT * FROM vacances WHERE FinVacances > ".time()." and IDEmploye = ".$Info['IDEmploye']." ORDER BY DebutVacances ASC";
$SQL = new sqlclass();
$SQL->Select($Req);

if($SQL->NumRow() <> 0){

    $MainOutput->OpenRow();
    $MainOutput->OpenCol('100%',2);
    $MainOutput->addtexte('----------Vacances--------------------------------------','Titre');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    While($Rep = $SQL->FetchArray()){
        $MainOutput->OpenRow();
        $MainOutput->OpenCol();
        $MainOutput->AddTexte($Rep['Raison']);
        $MainOutput->addlink("index.php?Action=Delete_Vacances&Section=Employe&IDVacances=".$Rep['IDVacances']."&IDEmploye=".$Info['IDEmploye'],"<img src=b_del.png border=0>");
        $MainOutput->CloseCol();
        $MainOutput->OpenCol();
        $MainOutput->addTexte(date("d M Y",$Rep['DebutVacances'])." au ".date("d M Y",$Rep['FinVacances']));
        $MainOutput->CloseCol();

        $MainOutput->CloseRow();
    }
}



$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Contact----------------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);


$MainOutput->addtitledoutput('Adresse',$Info['Adresse']);
$Req = "SELECT IDSecteur, Nom FROM secteur ORDER BY Nom ASC";
$MainOutput->addtitledoutput('Secteur',$Info['IDSecteur']);
$MainOutput->addtitledoutput('Ville',$Info['Ville']);
$MainOutput->addtitledoutput('Code Postal',$Info['CodePostal']);
$MainOutput->addtitledoutput('Email',$Info['Email']);
$MainOutput->addtitledphone('Telephone Principal',$Info['TelP']);
$MainOutput->addtitledphone('Telephone Autre',$Info['TelA']);
$MainOutput->addtitledphone('Cell',$Info['Cell']);
$MainOutput->addtitledphone('Paget',$Info['Paget']);

$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Compagnie----------------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);

$MainOutput->addtitledoutput('Date d\'embauche', datetostr($Info['DateEmbauche']));
$Status = array('Temps plein'=>'Temps plein','Secondaire'=>'Secondaire','CéGEP'=>'CéGEP','Université'=>'Université','Bureau'=>'Bureau');
$Session = get_saison_list();
$Saison = array();

foreach($Session as $v){
    $Saison[$v]=$v;
}

$str_status = "";
if(array_key_exists($Info['Session'],$Status))
{
    $str_status = $Status[$Info['Status']];
}

$MainOutput->addtitledoutput('Session',$Info['Session']);
$MainOutput->addtitledoutput('Status',$str_status);
$MainOutput->addtitledoutput('SalaireB','Salaire Bureau','5',$Info['SalaireB']);
$MainOutput->addtitledoutput('SalaireS','Salaire Sauveteur','5',$Info['SalaireS']);
$MainOutput->addtitledoutput('SalaireA','Salaire Assitant','5',$Info['SalaireA']);
$MainOutput->addtitledoutput('Cessation',$Info['Cessation']);
$MainOutput->addtitledoutput('Raison',$Info['Raison']);


$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->CloseTable();

echo $MainOutput->send(1);

?>