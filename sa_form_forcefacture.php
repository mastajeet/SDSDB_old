<?php
/**
 * Created by PhpStorm.
 * User: mastajeet
 * Date: 14-08-24
 * Time: 13:26
 */
const SHIFT_NON_FACTURES = 'Shift n\'ayant pas été facturé';
const MARK_SHIFT_AS_BILLED = 'Marquer shift comme facturés';
const GENERATE_FULL_BILL = 'Générer la facture totale';

$SQL = new sqlclass();
$SQL2 = new sqlclass();

if(isset($_POST['FORMInstallation']) and isset($_POST['FORMActionRadio'])){
    //Break The info
    $Info = explode("_",$_POST['FORMInstallation']);
    switch($_POST['FORMActionRadio']){
        CASE "Mark":{
            $Info2 = get_client_info_bycote($Info[0]);
            $Ins = get_installations($Info2['IDClient']);


            $Req = "UPDATE shift set facture =1 where IDInstallation IN(".StringArrayToString($Ins).") and Semaine=".$Info[1];
            $SQL->uPDATE($Req);
            BREAK;
        }
        CASE "GenerateOnly":{

            BREAK;
        }
        CASE "GenerateFull":{
            $SQLins = new sqlclass();
            $ReqIDIns = "SELECT DISTINCT shift.IDInstallation FROM shift JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE installation.Cote='".$Info[0]."' AND Semaine=".$Info[1]." ORDER BY Nom ASC";
            $SQLins->SELECT($ReqIDIns);
            while($Repins = $SQLins->FetchArray()){
                $Req = "SELECT Start, End, Jour, shift.TXH, installation.Nom, shift.Assistant, Ferie, shift.IDEmploye FROM shift JOIN installation JOIN client on shift.IDInstallation = installation.IDInstallation AND client.IDClient = installation.IDClient WHERE shift.IDInstallation = ".$Repins[0]." AND Semaine=".$Info[1]." ORDER BY installation.Nom ASC, Jour ASC, Assistant ASC, Start ASC";
                $SQL->SELECT($Req);
                $i =0;
                $Shift = array();

                while($Rep = $SQL->FetchArray()){
                    $Titre = "Sauveteur";
                    if($Rep[5])
                        $Titre = "Deuxi�me Sauveteur";
                    if($i>0 && $Shift[$i-1]['End'] == $Rep[0]){
                        $Shift[$i-1]['End'] = $Rep[1];
                        $Shift[$i-1]['Notes'] = substr($Shift[$i-1]['Notes'],0,-1);
                        $Shift[$i-1]['Notes'] .= "-".get_employe_initials($Rep[7]).")";
                    }else{
                        $Shift[$i] = array('Start'=>$Rep[0],'End'=>$Rep[1],'Jour'=>$Rep[2],'TXH'=>$Rep[3],'Notes'=>$Titre.": ".$Rep[4]." (".get_employe_initials($Rep[7]).")",'Ferie'=>$Rep[6]);

                        $i++;
                    }

                }
                $IDFacture = add_facture($Info[0],$Info[1]);

                foreach($Shift as $v){


                    $v['End'] = $v['End'] - bcmod($v['End'],36);
                    $v['Start'] = $v['Start'] - bcmod($v['Start'],36);



                    if($v['Start']==0 and $v['End']==14400)
                        $v['Notes'] = $v['Notes']." (Minimum 4h)";

                    if(is_ferie($v['Jour']*86400+$Info[1])){
                        if($v['Ferie']<>1){
                            $v['TXH'] = $v['TXH']*$v['Ferie'];
                            $v['Notes'] = $v['Notes']." (x".$v['Ferie']." Journ�e F�ri�e)";
                        }
                    }
                    $Req = "INSERT INTO factsheet(`IDFacture`,`Start`,`End`,`Jour`,`TXH`,`Notes`) VALUES(".$IDFacture.",'".$v['Start']."','".$v['End']."','".$v['Jour']."','".$v['TXH']."','".addslashes($v['Notes'])."')";
                    $SQL->Insert($Req);
                }
                update_facture_balance($IDFacture);
            }

            $Req = "UPDATE shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation SET Facture=1 WHERE `Semaine`=".$Info[1]." AND Cote='".$Info[0]."'";
            $SQL->Query($Req);
            $Modifie=TRUE;
            $_GET['IDFacture'] = $IDFacture;


            BREAK;
        }

    }
}
if(isset($_POST['FORMActionRadio']) and $_POST['FORMActionRadio']=="GenerateFull"){
    $MainOutput->addoutput(include('display_facture.php'),0,0);
}else{


    $FirstDayOfYear = mktime(null, null, null, 1,1,get_vars('BoniYear'));
    $UpperDate = min($LastDayOfYear = mktime(null, null, null, 12,31,get_vars('BoniYear')),get_last_sunday(1));
    $InsSelected = NULL;
    if(isset($_POST['Installation'])){
        $InsSelected = $_POST['Installation'] ;
    }

    $Req = "Select distinct Cote, Semaine, count(IDShift) as nb from installation join shift on installation.IDInstallation = shift.IDInstallation where !Facture and IDEmploye<>0 and Semaine+60*60*24*Jour>=".$FirstDayOfYear." AND  Semaine<=".$UpperDate."  group by Cote, Semaine order by Semaine ASC";
    $SQL->SELECT($Req);

    $MainOutput->Addform(SHIFT_NON_FACTURES,'index.php?Section=SuperAdmin&ToDo=Force_Facture');
    $Radio = array();
    while($Rep = $SQL->FetchArray()){
        $Req2 = "Select IDFacture from facture where !Credit and Cote='".$Rep['Cote']."' and Semaine=".$Rep['Semaine'];
        $Desc = "<a href=index.php?Cote=".$Rep['Cote']." target=_BLANK>".get_installation_by_cote_in_string($Rep['Cote'])."</a>";
        $EndDate = get_end_dates(0,$Rep['Semaine']);
        $SQL2->Select($Req2);
        $Desc .= " - <a href=index.php?Section=Display_Shift&Semaine=".$Rep['Semaine']." target=_BLANK1>".$EndDate['Start']."</a> (".$Rep['nb']." Shifts non factur�s)";

        if($SQL2->NumRow()>0){
            $Rep2 = $SQL2->FetchArray();
            $Desc .= " - <a href=index.php?Section=Display_Facture&IDFacture=".$Rep2['IDFacture']."&ToPrint=TRUE target=_BLANK2>Facture</a>";
        }
        $Radio[$Rep['Cote']."_".$Rep['Semaine']] =$Desc;
    }
    $MainOutput->inputradio('Installation',$Radio,$InsSelected,Null,"VER");

    $ActionRadio = array('' . MARK_SHIFT_AS_BILLED . '' =>'Mark', GENERATE_FULL_BILL =>'GenerateFull');
    $MainOutput->inputradio('ActionRadio',$ActionRadio);
    $MainOutput->inputhidden_env('Section','SuperAdmin');

    $MainOutput->formsubmit();


}

echo $MainOutput->send(1);

?>