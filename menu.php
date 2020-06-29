<?PHP

const EMPLOYEE_LIST = 'Liste d\'employé';
const ADD_EMPLOYEE = 'Ajouter un employé';
const ADD_QUALIFICATION = 'Ajouter une qualification';
const BONUS_CRUSHER = 'Bonus Crusher';
const MESSAGE = 'Message';
const NEXT_SHIFT = 'Employés libres';
const CALCULATE_HOLIDAY = 'Calculer un férié';
const EQUIPMENT = 'Matériel';
const TODO_LIST = 'Liste à faire';
const LIST_DONE = 'Liste effectuée';
const BILLING_DETAILS = 'Détails de facturation';
const DELOG = 'Se&nbsp;Déconnecter';
const EMPLOYEE = 'Employé';
const DISPLAY_CURRENT_SCHEDULE = 'Afficher l\'horaire courant';
const DISPLAY_PAST_SCHEDULE = 'Afficher l\'horaire passé';
const LIST_BUREAU_EMPLOYEE = 'Liste employe bureau';
const MONTHLY_TRANSACTIONS = 'Transaction mensuelles';
const GENERATE_KIMOBY_CSV = 'Kimoby CSV';
$SQL = new sqlclass;

$Categorie = NULL;
$Client = NULL;
$Installation = NULL;


if(isset($_GET['Section'])){
    $_GET['MenuSection'] = $_GET['Section'];
}

if(isset($_GET['IDHoraire']) || isset($_POST['IDHoraire'])){
    if(isset($_POST['IDHoraire'])){
        $_GET['IDHoraire'] = $_POST['IDHoraire'];
        $_GET['Section'] = "Horshift";
    }
    $Req = "SELECT IDInstallation FROM installation WHERE IDHoraire =".$_GET['IDHoraire'];
    $SQL->SELECT($Req);
    $Rep = $SQL->FetchArray();
    $_GET['IDInstallation'] = $Rep[0];
}

if(isset($_GET['IDFacture'])){
    $Req = "SELECT IDInstallation FROM installation JOIN facture on facture.Cote = installation.Cote WHERE IDFacture=".$_GET['IDFacture'];
    $SQL->SELECT($Req);
    $Rep = $SQL->FetchArray();
    $_GET['IDInstallation'] = $Rep[0];
}

if(isset($_POST['FORMGenerateCote'])){
    $Req = "SELECT IDInstallation FROM installation WHERE Cote='".$_POST['FORMGenerateCote']."'";
    $SQL->SELECT($Req);
    $Rep = $SQL->FetchArray();
    $_GET['IDInstallation'] = $Rep[0];
}

if(isset($_GET['IDInstallation'])){
    $Info = get_installation_info($_GET['IDInstallation']);
    $_GET['MenuCat']= 'Client';
    $_GET['MenuClient'] = $Info['IDClient'];
    $_GET['MenuInstallation'] = $Info['Cote'];
}


if(isset($_POST['FORMIDClient']) OR isset($_GET['IDClient']) OR isset($_POST['IDClient'])){
    if(isset($_GET['IDClient']))
        $_POST['FORMIDClient'] = $_GET['IDClient'];
    if(isset($_POST['IDClient']))
        $_POST['FORMIDClient'] = $_POST['IDClient'];
    $_GET['MenuCat']= 'Client';
    $_GET['MenuClient'] = $_POST['FORMIDClient'];
}




if(isset($_GET['MenuClient'])){
    $Categorie = "Client";
    $Client = $_GET['MenuClient'];
    $Section = "Display_Client";
    $_POST['FORMIDClient']=$_GET['MenuClient'];
}

if(isset($_GET['MenuInstallation']) OR isset($_GET['Cote']) OR isset($_POST['FORMCote']) ){
    if(isset($_POST['FORMCote']))
        $_GET['MenuInstallation']=$_POST['FORMCote'];
    if(isset($_GET['Cote']))
        $_GET['MenuInstallation']=$_GET['Cote'];
    $Categorie = "Client";
    $Req = "SELECT IDClient FROM installation WHERE Cote = '".$_GET['MenuInstallation']."'";
    $SQL->Select($Req);
    $Info = $SQL->FetchArray();
    $_GET['MenuClient'] = $Info['IDClient'];
    $Section = "Display_Facturation";
    $_GET['Cote'] = $_GET['MenuInstallation'];
}

if(isset($_GET['MenuCat'])){
    $Categorie = $_GET['MenuCat'];

    if($Categorie=="Employe")
        $Section = "EmployeList";

    if($Categorie=="Materiel")
        $Section = "Display_Materiel";

    if($Categorie=="Facturation")
        $Section = "Generate_Facture";
    if($Categorie=="FacturationMensuelle")
        $Section = "Generate_Facture_Mensuelle";
    if($Categorie=="MonthlyTransaction")
        $Section = "DossierFacturation_DisplayMonthlyTransactions";

    if($Categorie=="Search")
        $Section = "Search";



    if($Categorie=="Facture_DisplayFacturationReport")
        $Section = "Facture_DisplayFacturationReport";
    if($Categorie=="Vars")
        $Section = "Vars";
    if($Categorie=="SuperAdmin")
        $Section = "SuperAdmin";

    if($Categorie=="Paye")
        $Section ="Add_Paye";


    if($Categorie=="Inspection")
        $Section ="Inspection";
}

if(isset($_GET['MenuSection'])){
    $Section = $_GET['MenuSection'];
    if($_GET['MenuSection']=="EmployeList" OR $_GET['MenuSection']=="Add_Saison" OR $_GET['MenuSection']=="Close_Saison")
        $_GET['MenuCat'] = "Employe";


    if($_GET['MenuSection']=="Modifie_Employe")
            $_GET['MenuCat'] = "Employe";

    if($_GET['MenuSection']=="List_Bureau_Employee")
        $_GET['MenuCat'] = "Employe";




    if($_GET['MenuSection']== MESSAGE || $_GET['MenuSection']=="Message_Form")
        $_GET['MenuCat'] = "Employe";
    if($_GET['MenuSection']=="Copy_Horaire")
        $_GET['MenuCat'] = "Horaire";
    if($_GET['MenuSection']=="BoniCrush")
        $_GET['MenuCat'] = "Employe";
    if($_GET['MenuSection']=="Remplacement")
        $_GET['MenuCat'] = "Horaire";
    if($_GET['MenuSection']=="Display_Shift")
        $_GET['MenuCat'] = "Horaire";
    if($_GET['MenuSection']=="Display_Shit")
        $_GET['MenuCat'] = "Horaire";
    if($_GET['MenuSection']=="Date_Lookup")
        $_GET['MenuCat'] = "Horaire";
    if($_GET['MenuSection']=="NonWorking")
        $_GET['MenuCat'] = "Employe";


    if($_GET['MenuSection']=="Next_WorkingDay")
        $_GET['MenuCat'] = "Employe";
    if($_GET['MenuSection']=="Display_Horshift")
        $_GET['MenuCat'] = "Horaire";
    if($_GET['MenuSection']=="Add_Remplacement")
        $_GET['MenuCat'] = "Horaire";
    if($_GET['MenuSection']=="Display_Timesheet")
        $_GET['MenuCat'] = "Paye";
    if($_GET['MenuSection']=="Calcul_Ferie")
        $_GET['MenuCat'] = "Paye";
    if($_GET['MenuSection']=="Add_Paye")
        $_GET['MenuCat'] = "Paye";
    if($_GET['MenuSection']=="Client_Form")
        $_GET['MenuCat'] = "Client";
    if($_GET['MenuSection']=="Add_Facture")
        $_GET['MenuCat'] = "Client";
    if($_GET['MenuSection']=="Generate_Facture")
        $_GET['MenuCat'] = "Horaire";
    if($_GET['MenuSection']=="Conf_Shift")
        $_GET['MenuCat'] = "Horaire";
    if($_GET['MenuSection']=="Employe")
        $_GET['MenuCat'] = "Employe";
    if($_GET['MenuSection']=="TimeSheet")
        $_GET['MenuCat'] = "Paye";
    if($_GET['MenuSection']=="Add_Shift")
        $_GET['MenuCat'] = "Horaire";
    if($_GET['MenuSection']=="Shift_Form")
        $_GET['MenuCat'] = "Horaire";
    if($_GET['MenuSection']=="Ajustement")
        $_GET['MenuCat'] = "Paye";
    if($_GET['MenuSection']=="Inspection")
        $_GET['MenuCat'] = "Inspection";
    if($_GET['MenuSection']=="SuiviInspection")
        $_GET['MenuCat'] = "Inspection";
    if($_GET['MenuSection']=="AddInspection")
        $_GET['MenuCat'] = "Inspection";

    if(isset($_GET['MenuCat']))
        $Categorie = $_GET['MenuCat'];
}
$Temp = "";
echo $MainOutput->send(1);
if($MainOutput->output<>""){
    $Temp = $MainOutput->send(1);

    $MainOutput->OpenRow();
    $MainOutput->OpenCol(250,4);
    $MainOutput->AddTexte('Message :','Titre');
    $MainOutput->addoutput($Temp,0,0);
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();
    $Temp = $MainOutput->Send(1);
}


$SQL = new sqlclass;
$SQL2 = new sqlclass;
$MainOutput->OpenTable('250');



$MainOutput->OpenRow(1);
$MainOutput->OpenCol(20);
$MainOutput->AddPic('carlos.gif','width=20, height=1');
$MainOutput->CloseCol();
$MainOutput->OpenCol(20);
$MainOutput->AddPic('carlos.gif','width=20, height=1');
$MainOutput->CloseCol();
$MainOutput->OpenCol(20);
$MainOutput->AddPic('carlos.gif','width=20, height=1');
$MainOutput->CloseCol();
$MainOutput->OpenCol(190);
$MainOutput->AddPic('carlos.gif','width=190, height=1');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->Addoutput($Temp,0,0);


/**
$MainOutput->OpenRow();
$MainOutput->OpenCol(20);
$MainOutput->AddPic('f_cat.png');
$MainOutput->CloseCol();
$MainOutput->OpenCol('230',3);
$MainOutput->AddLink('../HELP/SDSDB/','Aide','_Blank');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
 **/
$MainOutput->OpenRow();
$MainOutput->OpenCol(20);
$MainOutput->AddPic('f_cat.png');
$MainOutput->CloseCol();
$MainOutput->OpenCol('230',3);
$MainOutput->AddLink('index.php?MenuCat=Employe', EMPLOYEE);
$MainOutput->CloseCol();
$MainOutput->CloseRow();





if(isset($_GET['MenuCat']) && $_GET['MenuCat']=="Employe"){

    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND $Section=="EmployeList")
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=EmployeList', EMPLOYEE_LIST);
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();


    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND $Section=="Employe")
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Modifie_Employe', ADD_EMPLOYEE);
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

if($authorization->verifySuperAdmin($_COOKIE)){
        $MainOutput->OpenRow();
        $MainOutput->OpenCol(20);
        $MainOutput->AddTexte('&nbsp;');
        $MainOutput->CloseCol();
        $MainOutput->OpenCol(20);
        if(isset($Section) AND $Section=="List_Bureau_Employee")
            $MainOutput->AddPic('f_open.png');
        else
            $MainOutput->AddPic('f_close.png');
        $MainOutput->CloseCol();
        $MainOutput->OpenCol('230',2);
        $MainOutput->AddLink('index.php?MenuSection=List_Bureau_Employee', LIST_BUREAU_EMPLOYEE);
        $MainOutput->CloseCol();
        $MainOutput->CloseRow();
}


    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND $Section=="Add_Qualif")
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Add_Qualif', ADD_QUALIFICATION);
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND ($Section=="BoniCrush" || $Section=="BoniCrushed"))
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=BoniCrush', BONUS_CRUSHER);
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();


    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND ($Section== MESSAGE || $Section=="Message_Form"))
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Message', MESSAGE);
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();



    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND ($Section=="Get_NotWorkingEmployee"))
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Get_NotWorkingEmployee&ToPrint=TRUE', NEXT_SHIFT,'_BLANK');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();


    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND $Section=="Add_Saison")
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Add_Saison','Ajouter une saisons');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND $Section=="Close_Saison")
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');

    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Close_Saison','Fermer une saison');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

}
$MainOutput->OpenRow();
$MainOutput->OpenCol(20);
$MainOutput->AddPic('f_cat.png');
$MainOutput->CloseCol();
$MainOutput->OpenCol('230',3);
$MainOutput->AddLink('index.php?MenuCat=Horaire&MenuSection=Remplacement','Horaire');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
if($Categorie=="Horaire"){

    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND ($Section=="Display_Shift" || $Section=="Add_Shift" || $Section=="Shift_Form") AND $_GET['Semaine']==get_last_sunday())
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');

    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Display_Shift', DISPLAY_CURRENT_SCHEDULE);
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();


    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND $Section=="Display_Shift" AND isset($_GET['Semaine']) && $_GET['Semaine'] <> get_last_sunday() )
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');

    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Display_Shift&Semaine='.get_last_sunday(1), DISPLAY_PAST_SCHEDULE);
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND $Section=="Display_Shift" AND isset($_GET['Semaine']) && $_GET['Semaine'] <> get_last_sunday() )
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');

    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?TOPRINT=1&Action=KimobyCSV_Generate',GENERATE_KIMOBY_CSV,'_BLANK');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();


    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND $Section=="Copy_Horaire")
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');

    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Copy_Horaire','Copier les horaires');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();


    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND $Section=="Display_Horshift")
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');

    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Display_Horshift','Horaire Officiel');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();




    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND $Section=="Remplacement")
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');

    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Remplacement','Remplacements');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND $Section=="Date_Lookup")
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');

    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Date_Lookup','Recherche de date');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

}




if($authorization->verifySuperAdmin($_COOKIE)) {

$MainOutput->OpenRow();
$MainOutput->OpenCol(20);
$MainOutput->AddPic('f_cat.png');
$MainOutput->CloseCol();
$MainOutput->OpenCol('230',3);
$MainOutput->AddLink('index.php?MenuCat=Paye','Paye');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

    if ($Categorie == "Paye") {


        $MainOutput->OpenRow();
        $MainOutput->OpenCol(20);
        $MainOutput->AddTexte('&nbsp;');
        $MainOutput->CloseCol();
        $MainOutput->OpenCol(20);
        if (isset($Section) AND $Section == "Add_Paye")
            $MainOutput->AddPic('f_open.png');
        else
            $MainOutput->AddPic('f_close.png');

        $MainOutput->CloseCol();
        $MainOutput->OpenCol('230', 2);
        $MainOutput->AddLink('index.php?MenuSection=Add_Paye', 'Ajouter une paye');
        $MainOutput->CloseCol();
        $MainOutput->CloseRow();

        $MainOutput->OpenRow();
        $MainOutput->OpenCol(20);
        $MainOutput->AddTexte('&nbsp;');
        $MainOutput->CloseCol();
        $MainOutput->OpenCol(20);
        if (isset($Section) AND $Section == "Display_Timesheet")
            $MainOutput->AddPic('f_open.png');
        else
            $MainOutput->AddPic('f_close.png');

        $MainOutput->CloseCol();
        $MainOutput->OpenCol('230', 2);
        $MainOutput->AddLink('index.php?MenuSection=Display_Timesheet', 'Afficher une paye');
        $MainOutput->CloseCol();
        $MainOutput->CloseRow();


        $MainOutput->OpenRow();
        $MainOutput->OpenCol(20);
        $MainOutput->AddTexte('&nbsp;');
        $MainOutput->CloseCol();
        $MainOutput->OpenCol(20);
        if (isset($Section) AND $Section == "Calcul_Ferie")
            $MainOutput->AddPic('f_open.png');
        else
            $MainOutput->AddPic('f_close.png');

        $MainOutput->CloseCol();
        $MainOutput->OpenCol('230', 2);
        $MainOutput->AddLink('index.php?MenuSection=Calcul_Ferie', CALCULATE_HOLIDAY, '_BLANK');
        $MainOutput->CloseCol();
        $MainOutput->CloseRow();

    }

    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddPic('f_cat.png');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',3);
    $MainOutput->AddLink('index.php?MenuCat=Facturation&Semaine='.get_last_sunday(1),'Facturation');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddPic('f_cat.png');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',3);
    $MainOutput->AddLink('index.php?MenuCat=FacturationMensuelle','Facturation Mensuelle');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();





    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddPic('f_cat.png');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',3);
    $MainOutput->AddLink('index.php?MenuCat=Facture_DisplayFacturationReport&ToPrint=TRUE', BILLING_DETAILS,'_BLANK');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();


    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddPic('f_cat.png');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',3);
    $MainOutput->AddLink('index.php?MenuCat=MonthlyTransaction', MONTHLY_TRANSACTIONS);
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

}



$MainOutput->OpenRow();
$MainOutput->OpenCol(20);
$MainOutput->AddPic('f_cat.png');
$MainOutput->CloseCol();
$MainOutput->OpenCol('230',3);
$MainOutput->AddLink('index.php?MenuCat=Materiel', EQUIPMENT);
$MainOutput->CloseCol();
$MainOutput->CloseRow();



$MainOutput->OpenRow();
$MainOutput->OpenCol(20);
$MainOutput->AddPic('f_cat.png');
$MainOutput->CloseCol();
$MainOutput->OpenCol('230',3);
$MainOutput->AddLink('index.php?MenuCat=Inspection&TODO=TRUE','Inspection');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

if($Categorie=="Inspection"){


    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND $Section=="Inspection" AND isset($_GET['TODO']))
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');

    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Inspection&TODO=TRUE', TODO_LIST);
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddTexte('&nbsp;');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol(20);
    if(isset($Section) AND ($Section=="Inspection" AND !isset($_GET['TODO'])) OR  $Section=="AddInspection")
        $MainOutput->AddPic('f_open.png');
    else
        $MainOutput->AddPic('f_close.png');

    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',2);
    $MainOutput->AddLink('index.php?MenuSection=Inspection', LIST_DONE);
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();


}




$MainOutput->OpenRow();
$MainOutput->OpenCol(20);
$MainOutput->AddPic('f_cat.png');
$MainOutput->CloseCol();
$MainOutput->OpenCol('230',3);
$MainOutput->AddLink('index.php?MenuCat=Search','Recherche');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


if($authorization->verifySuperAdmin($_COOKIE)){
    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddPic('f_cat.png');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',3);
    $MainOutput->AddLink('index.php?MenuCat=SuperAdmin','Modifications Super-Admin');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

}
    $MainOutput->OpenRow();
    $MainOutput->OpenCol(20);
    $MainOutput->AddPic('f_cat.png');
    $MainOutput->CloseCol();
    $MainOutput->OpenCol('230',3);
    $MainOutput->AddLink('index.php?MenuCat=Client','Client');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    if(!isset($Section) && $Categorie=="Client")
    $Section = "Default_Client";
if($Categorie=="Client"){
    $Req = "SELECT DISTINCT `client`.IDClient, `client`.Nom, sum(installation.Actif)
FROM client LEFT JOIN installation ON installation.IDClient = `client`.IDClient
WHERE `client`.Actif
GROUP BY `client`.IDClient
ORDER BY `client`.Nom ASC";

    $SQL->SELECT($Req);
    while($Rep = $SQL->FetchArray()){
        if($Rep[2]>=1){
            $MainOutput->OpenRow();
            $MainOutput->OpenCol(20);
            if(isset($_GET['MenuClient']) AND $_GET['MenuClient']==$Rep[0])
                $MainOutput->AddLink('index.php?MenuCat=Client','<img src=f_minus.png border=0>');
            else
                $MainOutput->AddLink('index.php?MenuClient='.$Rep[0],'<img src=f_plus.png border=0>');
            $MainOutput->CloseCol();
            $MainOutput->OpenCol(20);
            if(isset($_GET['MenuClient']) AND $_GET['MenuClient']==$Rep[0])
                $MainOutput->AddLink('index.php?MenuCat=Client','<img src=f_close.png border=0>');
            else
                $MainOutput->AddLink('index.php?MenuClient='.$Rep[0],'<img src=f_close.png border=0>');

            $MainOutput->CloseCol();
            $MainOutput->OpenCol(210,2);
            $MainOutput->AddLink('index.php?MenuClient='.$Rep[0],$Rep[1]);
            $MainOutput->CloseCol();
            $MainOutput->CloseRow();

            if(isset($_GET['MenuClient']) AND $_GET['MenuClient']==$Rep[0]){

                $Req2 = "SELECT Distinct Cote FROM installation WHERE Actif AND Saison AND IDClient = ".$Rep[0]." ORDER BY Nom ASC";
                $SQL2->SELECT($Req2);
                while($Rep2 = $SQL2->FetchArray()){
                    $MainOutput->OpenRow();

                    $MainOutput->OpenCol(20);
                    $MainOutput->AddTexte('&nbsp;');
                    $MainOutput->CloseCol();
                    $MainOutput->OpenCol(20);
                    $MainOutput->AddTexte('&nbsp;');
                    $MainOutput->CloseCol();
                    $MainOutput->OpenCol(20);
                    $Installations = get_installation_by_cote_in_string($Rep2[0]);
                    if(isset($_GET['MenuInstallation']) AND $_GET['MenuInstallation']==$Rep2[0])
                        $MainOutput->AddLink('index.php?MenuInstallation='.$Rep2[0],'<img src=f_open.png border=0>');
                    else
                        $MainOutput->AddLink('index.php?MenuInstallation='.$Rep2[0],'<img src=f_close.png border=0>');
                    $MainOutput->CloseCol();
                    $MainOutput->OpenCol(190);
                    $MainOutput->AddLink('index.php?MenuInstallation='.$Rep2[0],$Installations);
                    $MainOutput->CloseCol();
                    $MainOutput->CloseRow();
                }
            }
        }
    }
}
$MainOutput->OpenRow();
$MainOutput->OpenCol();
$MainOutput->AddPic('f_close.png');
$MainOutput->CloseCol();
$MainOutput->OpenCol('100%',3);
$MainOutput->AddLink('index.php?Action=Delog', DELOG);
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->CloseTable();

if($_GET['ToPrint']==FALSE)
    echo $MainOutput->send(1);
else
    $MainOutput->EmptyOutput();

?> 