<?php
const EMPLOYEE_INFO = 'Fiche Employé';
const NAME = 'Nom';
const SURNAME = 'Prenom';
const SCHEDULE_NAME = 'Nom Horaire';
const DATE_OF_BIRTH = 'Date Naissance';
const SOCIAL_SECURITY_NUMBER = 'Numéro d\'assurance sociale';
const NOTES = 'Notes';
$Info = get_employe_info($_GET['IDEmploye']);

$MainOutput->addlink('index.php?Section=Modifie_Employe&IDEmploye='.$Info['IDEmploye'], '<img src=assets/buttons/b_edit.png border=0>');
$MainOutput->addlink('index.php?Section=Employe&IDEmploye='.$Info['IDEmploye'].'&ToPrint=TRUE', '<img src=assets/buttons/b_print.png border=0>','_blank');
$MainOutput->addlink('index.php?Section=Employe_Horshift&IDEmploye='.$Info['IDEmploye'], '<img src=assets/buttons/b_fact.png border=0>');
$MainOutput->addlink('index.php?Section=Employe_Report&IDEmploye='.$Info['IDEmploye'].'&ToPrint=TRUE', '<img src=assets/buttons/b_sheet.png border=0>');
$MainOutput->addlink('index.php?Section=Employe_Horshift&IDEmploye='.$Info['IDEmploye'], '<img src=assets/buttons/b_fact.png border=0>');
$MainOutput->addlink('index.php?Section=Display_AskedRemplacement&IDEmploye='.$Info['IDEmploye'], '<img src=assets/buttons/b_del.png border=0>');

$can_see_protected_fields = $authorization->verifySuperAdmin($_COOKIE);

$MainOutput->OpenTable();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->addtexte(EMPLOYEE_INFO,'Titre');
$MainOutput->br(2);
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Personnel------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->addtitledoutput($title='Numero Employe', $string = $Info['IDEmploye']);

$MainOutput->addtitledoutput(NAME,$string=$Info[NAME]);
$MainOutput->addtitledoutput(SURNAME,$Info[SURNAME]);
$MainOutput->addtitledoutput(SCHEDULE_NAME,$Info['HName']);
$MainOutput->addtitledoutput(DATE_OF_BIRTH, datetostr($Info['DateNaissance']));

if($can_see_protected_fields){
    $MainOutput->addtitledoutput(SOCIAL_SECURITY_NUMBER, $Info['NAS']);
}else{
    $MainOutput->addtitledoutput(SOCIAL_SECURITY_NUMBER, "*** *** ".substr($Info['NAS'],6,3));
}
$MainOutput->addtitledoutput(NOTES,$Info['Notes']);
$MainOutput->CloseCol();
$MainOutput->CloseRow(); 


//check s'il y a des vacances à venir
$vacances_threshold = time()-24*3600;
$Req = "SELECT * FROM vacances WHERE FinVacances > ".$vacances_threshold." and IDEmploye = ".$Info['IDEmploye']." ORDER BY DebutVacances ASC";
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
        $MainOutput->addlink("index.php?Action=Delete_Vacances&Section=Employe&IDVacances=".$Rep['IDVacances']."&IDEmploye=".$Info['IDEmploye'], "<img src=assets/buttons/b_del.png border=0>");
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

$str_secteur = "";
if($Info['IDSecteur']<>" " and $Info['IDSecteur']<>""){
    $SQL_secteur = new SQLClass();
    $Req_secteur = "SELECT IDSecteur, Nom FROM secteur WHERE IDSecteur = ".$Info['IDSecteur'];
    $SQL_secteur->Select($Req_secteur);
    while ($Rep_secteur = $SQL_secteur->FetchArray())
    {
        $str_secteur = $Rep_secteur[NAME];
    }


}

$MainOutput->addtitledoutput('Secteur',$str_secteur);
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
$Status = array('Temps plein'=>'Temps plein','Secondaire'=>'Secondaire','CÉGEP'=>'CÉGEP','Université'=>'Université','Bureau'=>'Bureau');
$Session = get_saison_list();
$Saison = array();

foreach($Session as $v){
    $Saison[$v]=$v;
}

$str_status = "";
if(array_key_exists($Info['Status'],$Status))
{
    $str_status = $Status[$Info['Status']];
}

$MainOutput->addtitledoutput('Session',$Info['Session']);
$MainOutput->addtitledoutput('Status',$str_status);
$MainOutput->addtitledoutput('SalaireB',$Info['SalaireB']);
$MainOutput->addtitledoutput('SalaireS',$Info['SalaireS']);
$MainOutput->addtitledoutput('SalaireA',$Info['SalaireA']);
$MainOutput->addtitledoutput('Cessation',$Info['Cessation']);
$MainOutput->addtitledoutput('Raison',$Info['Raison']);


$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->CloseTable();


echo $MainOutput->send(1);

?>