<?PHP
const EMPLOYEE_NUMBER = 'Numéro d\'employé';
const ADD_MODIFY_EMPLOYEE = 'Ajouter / Modifier un employé';
const NAME = 'Nom';
const SURNAME = 'Prénom';
const SCHEDULE_NAME = 'Nom Horaire';
const DATE_OF_BIRTH = 'Date de naissance';
const SOCIAL_SECURITY_NUMBER = 'Numéro d\assurance sociale';
const NOTES = 'Notes';
const PHONE_PRINCIPAL = 'Tél. Principal';
const PHONE_SECONDARY = 'Tél. Autre';
const CELLPHONE = 'Cellulaire';
const PAGET = 'Paget';
const LEAVING_REASON = 'Raison du départ';
const ADD_MODIFY = 'Ajouter / Modifier';
const EMPLOYEE_STATUS = array('Temps plein' => 'Temps plein', 'Secondaire' => 'Secondaire', 'CÉGEP' => 'CÉGEP', 'Université' => 'Université', 'Bureau' => 'Bureau');

$MainOutput->addform(ADD_MODIFY_EMPLOYEE);
$MainOutput->inputhidden_env('Action','Employe');
if(isset($_GET['IDEmploye'])){
	$Info = get_employe_info($_GET['IDEmploye']);
	$MainOutput->inputhidden_env('IDEmploye',$_GET['IDEmploye']);
	$MainOutput->inputhidden_env('Update',TRUE);
}else{
	$Info = array('IDEmploye'=>'','HName'=>'','Ville'=>'Québec','Status'=>'','NAS'=>'', NAME =>'','Prenom'=>'','Session'=>get_vars('Saison'),'DateNaissance'=>0,'Adresse'=>'','CodePostal'=>'','Email'=>'','TelM'=>'','TelP'=>'','TelA'=>'','Cell'=>'', PAGET =>'','IDSecteur'=>'','Cessation'=>'', NOTES =>'','Raison'=>'','SalaireB'=>'9.50','SalaireS'=>'9.75','SalaireA'=>'9.25','DateEmbauche'=>0,'Engage'=>1,'EAssistant'=>'');
	$MainOutput->inputhidden_env('Update',FALSE);
}




$MainOutput->addlink('index.php?Section=Employe_Report&IDEmploye='.$Info['IDEmploye'].'&ToPrint=TRUE','<img src=b_sheet.png border=0>');
$MainOutput->addlink('index.php?Section=Employe_Horshift&IDEmploye='.$Info['IDEmploye'],'<img src=b_fact.png border=0>');
$MainOutput->addlink('index.php?Section=Display_AskedRemplacement&IDEmploye='.$Info['IDEmploye'],'<img src=b_del.png border=0>');

$MainOutput->inputtext('IDEmploye', EMPLOYEE_NUMBER,'3',$Info['IDEmploye']);


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Personnel------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->inputtext(NAME, NAME,'28',$Info[NAME]);
$MainOutput->inputtext('Prenom', SURNAME,'28',$Info['Prenom']);
$MainOutput->inputtext('HName', SCHEDULE_NAME,'28',$Info['HName']);
$MainOutput->inputtime('DateNaissance', DATE_OF_BIRTH,$Info['DateNaissance'],array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->inputtext('NAS', SOCIAL_SECURITY_NUMBER,'9',$Info['NAS']);
$MainOutput->textarea(NOTES, NOTES,'25','2',$Info[NOTES]);



//check s'il y a des vacances ? venir
$vacances_threshold = time()-3600*24;
$Req = "SELECT * FROM vacances WHERE FinVacances >= ".$vacances_threshold." and IDEmploye = ".$Info['IDEmploye']." ORDER BY DebutVacances ASC";
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
$MainOutput->inputphone('TelP', PHONE_PRINCIPAL,$Info['TelP']);
$MainOutput->inputphone('TelA', PHONE_SECONDARY,$Info['TelA']);
$MainOutput->inputphone('Cell', CELLPHONE,$Info['Cell']);
$MainOutput->inputphone(PAGET, PAGET,$Info['Paget']);


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Compagnie----------------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->inputtime('DateEmbauche','Date d\'embauche',$Info['DateEmbauche'],array('Date'=>TRUE,'Time'=>FALSE));
$Status = EMPLOYEE_STATUS;
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
$MainOutput->textarea('Raison', LEAVING_REASON,'25','2',$Info['Raison']);


$MainOutput->formsubmit(ADD_MODIFY);
echo $MainOutput->send(1);

?>
