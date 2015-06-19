<?PHP
$MainOutput->addform('Ajouter / Modifier un employé');
$MainOutput->inputhidden_env('Action','Employe');
if(isset($_GET['IDEmploye'])){
	$Info = get_employe_info($_GET['IDEmploye']);
	$MainOutput->inputhidden_env('IDEmploye',$_GET['IDEmploye']);
	$MainOutput->inputhidden_env('Update',TRUE);
}else{
	$Info = array('IDEmploye'=>'','HName'=>'','Ville'=>'Quï0bec','Status'=>'','NAS'=>'','Nom'=>'','Prenom'=>'','Session'=>get_vars('Saison'),'DateNaissance'=>0,'Adresse'=>'','CodePostal'=>'','Email'=>'','TelM'=>'','TelP'=>'','TelA'=>'','Cell'=>'','Paget'=>'','IDSecteur'=>'','Cessation'=>'','Notes'=>'','Raison'=>'','SalaireB'=>'9.50','SalaireS'=>'9.75','SalaireA'=>'9.25','DateEmbauche'=>0,'Engage'=>1,'EAssistant'=>'');
	$MainOutput->inputhidden_env('Update',FALSE);
}




$MainOutput->addlink('index.php?Section=Employe_Report&IDEmploye='.$Info['IDEmploye'].'&ToPrint=TRUE','<img src=b_sheet.png border=0>');
$MainOutput->addlink('index.php?Section=Employe_Horshift&IDEmploye='.$Info['IDEmploye'],'<img src=b_fact.png border=0>');
$MainOutput->addlink('index.php?Section=Display_AskedRemplacement&IDEmploye='.$Info['IDEmploye'],'<img src=b_del.png border=0>');

$MainOutput->inputtext('IDEmploye','Numéro d\'employé','3',$Info['IDEmploye']);


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Personnel------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->inputtext('Nom','Nom','28',$Info['Nom']);
$MainOutput->inputtext('Prenom','Prénom','28',$Info['Prenom']);
$MainOutput->inputtext('HName','Nom Horaire','28',$Info['HName']);
$MainOutput->inputtime('DateNaissance','Date de naissance',$Info['DateNaissance'],array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->inputtext('NAS','Numéro d\assurance sociale','9',$Info['NAS']);
$MainOutput->textarea('Notes','Notes','25','2',$Info['Notes']);



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

$MainOutput->inputtext('Adresse','Adresse','28',$Info['Adresse']);
$Req = "SELECT IDSecteur, Nom FROM secteur ORDER BY Nom ASC";
$MainOutput->inputselect('IDSecteur',$Req,$Info['IDSecteur'],'Secteur');
$MainOutput->inputtext('Ville','Ville','28',$Info['Ville']);
$MainOutput->inputtext('CodePostal','Code Postal','7',$Info['CodePostal']);
$MainOutput->inputtext('Email','Courriel','28',$Info['Email']);
$MainOutput->inputphone('TelP','Tél. Principal',$Info['TelP']);
$MainOutput->inputphone('TelA','Tél. Autre',$Info['TelA']);
$MainOutput->inputphone('Cell','Cellulaire',$Info['Cell']);
$MainOutput->inputphone('Paget','Paget',$Info['Paget']);


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Compagnie----------------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->inputtime('DateEmbauche','Date d\'embauche',$Info['DateEmbauche'],array('Date'=>TRUE,'Time'=>FALSE));
$Status = array('Temps plein'=>'Temps plein','Secondaire'=>'Secondaire','CéGEP'=>'CéGEP','Université'=>'Université','Bureau'=>'Bureau');
$Session = get_saison_list();
$Saison = array();
foreach($Session as $v){
	$Saison[$v]=$v;
}
$MainOutput->inputselect('Session',$Saison,$Info['Session'],'Session');
$MainOutput->inputselect('Status',$Status,$Info['Status'],'Status');
$MainOutput->inputselect('Emploi',array('1'=>'Assistant','0'=>'Sauveteur'),$Info['EAssistant']);
$MainOutput->inputtext('SalaireB','Salaire Bureau','5',$Info['SalaireB']);
$MainOutput->inputtext('SalaireS','Salaire Sauveteur','5',$Info['SalaireS']);
$MainOutput->inputtext('SalaireA','Salaire Assitant','5',$Info['SalaireA']);
$MainOutput->flag('Cessation',$Info['Cessation']);
$MainOutput->textarea('Raison','Raison du départ','25','2',$Info['Raison']);



/*
$Path = strstr($_SERVER['HTTP_REFERER'],'?');
$Path = substr($Path,1);
$Path = explode('&',$Path);

foreach($Path as $v){
	if($Var = explode('=',$v))
		$MainOutput->inputhidden_env($Var[0],$Var[1]);
}

*/


$MainOutput->formsubmit('Ajouter / Modifier');
echo $MainOutput->send(1);

?>
