<?PHP

if (isset($_POST['IDShift'])) {
    $Info = get_shift_info($_POST['IDShift']);

    if($_POST['FORMIDEmploye']==" "){
        $_POST['FORMIDEmploye']=0;
    }

    if(!isset($_POST['FORMTXH']) OR $_POST['FORMTXH']=="")
        $_POST['FORMTXH']=0;

    if(!isset($_POST['FORMSalaire']) OR $_POST['FORMSalaire']=="")
        $_POST['FORMSalaire']=0;

    $_GET['Semaine'] = $Info['Semaine'];
    $SQL = new SQLclass();
    $SQL2 = new SQLclass();
    if ($_POST['FORMRec'] == "") {
        $_POST['FORMRec'] = 1;
    }
    if (!isset($_POST['FORMAssistant']))
        $_POST['FORMAssistant'] = 0;
    if (!isset($_POST['FORMConfirme']))
        $_POST['FORMConfirme'] = 0;

    if (!isset($_POST['FORMIDEmploye']))
        $_POST['IDEmploye'] = NULL;


    //Trouver ce qui a été mis à jour par rapport au shift dans la BD
    $Difference = array();

    $Difference["Salaire"] = true;
    $Difference["THX"] = true;
    $Difference["IDEmploye"] = true;

    if ($_POST['FORMSalaire'] == $Info['Salaire'])
        $Difference["Salaire"] = false;
    if ($_POST['FORMTXH'] == $Info['TXH'])
        $Difference["TXH"] = false;
    if ($_POST['FORMIDEmploye'] == $Info['IDEmploye'])
        $Difference["IDEmploye"] = false;


    $EndWeek = get_next_sunday($_POST['FORMRec'] - 2, $Info['Semaine']);

    if ($_POST['FORMStart2'] == "" || $_POST['FORMEnd2'] == 0) {

        while ($Info['Semaine'] <= $EndWeek) {
            $Req = "SELECT IDShift FROM shift WHERE Semaine='" . $Info['Semaine'] . "' AND IDInstallation = '" . $_POST['IDInstallation'] . "' AND Jour='" . $_POST['FORMJour'] . "' AND Start = '" . $Info['Start'] . "' AND Assistant = '" . $_POST['FORMAssistant'] . "'";
            $SQL->Select($Req);
            $IDShift = $SQL->FetchArray();

            $Req = "DELETE FROM shift WHERE `IDShift`='" . $IDShift[0] . "'";
            $Log = new logshift(new shift($IDShift[0]), "DELETE");
            $SQL->QUERY($Req);
            $Info['Semaine'] = get_next_sunday(0, $Info['Semaine']);
        }
    } else {

        //Je ramasse ce qui caract�rise le shift Jour, D�but, fin, piscine
        $LogArray = array();
        $OldStart = $Info['Start'];
        $OldEnd = $Info['End'];
        $Start = 60 * ($_POST['FORMStart1'] + 60 * $_POST['FORMStart2']);
        $End = 60 * ($_POST['FORMEnd1'] + 60 * $_POST['FORMEnd2']);

        $Queries = array();
        $NoError = true;
        $ErrorStr = "";
        $FirstWeek = $Info['Semaine'];
        while ($Info['Semaine'] <= $EndWeek) {
            //Requete qui va chercher le ID du shift selon les caract�ristique du shift s�lecitonn�
            // il faut noter qu'ici seulement les shift qui ont le m�me d�but seront s�lectionn�s
            $Req = "SELECT IDShift, IDEmploye, TXH, Salaire FROM shift WHERE Semaine='" . $Info['Semaine'] . "' AND IDInstallation = '" . $_POST['IDInstallation'] . "' AND Jour='" . $_POST['FORMJour'] . "' AND Start = '" . $Info['Start'] . "' AND Assistant = '" . $_POST['FORMAssistant'] . "' ";
            $SQL->Select($Req);
            $TargetShift = $SQL->FetchArray();
            $IDShift = $TargetShift['IDShift'];

            /** Lors de la modification de juin 2015, j'ai ajouter ces conditions...je ne sais pas si je devrais les implémenter
             *
             * if (($TargetShift['Salaire'] <> $Info['Salaire']) AND $Difference['Salaire']) {
             * $NoError = false;
             * $ErrorStr .= "";
             * }
             * if (($TargetShift['TXH'] <> $Info['TXH']) AND $Difference['TXH']) {
             * $ErrorStr .= "";
             * $NoError = false;
             * }
             **/

            if (($TargetShift['IDEmploye'] <> 0 or $TargetShift['IDEmploye'] <> "") and (($TargetShift['IDEmploye'] <> $Info['IDEmploye']) AND $Difference['IDEmploye'])) {
                $EmployeInfo = get_info('employe', $TargetShift['IDEmploye']);

                //   $ErrorStr .= "Vous tentez de remplacer ".$EmployeInfo['Prenom']." ".$EmployeInfo['Nom']." la semaine du ".get_end_dates(0,$Info['Semaine'])['Start']."<br>";
                $NoError = false;
            }


            if ($_POST['FORMAttach']) {
                // REQUETE QUI V�RIFIE S'IL Y A UN SHIFT QUI FINI TOUT DE SUITE AVANT

                $Req = "SELECT IDShift FROM shift WHERE IDInstallation = '" . $_POST['IDInstallation'] . "' && `Jour`='" . $_POST['FORMJour'] . "' && `End`='" . $OldStart . "'  && `Semaine`='" . $Info['Semaine'] . "'&& Assistant='" . $_POST['FORMAssistant'] . "' ";
                $SQL->SELECT($Req);
                while ($Rep = $SQL->FetchArray()) {
                    $Queries[] = "UPDATE shift SET End= " . $Start . " WHERE IDShift=" . $Rep['IDShift'];
                    $LogArray[$Rep['IDShift']] = "LEFT SIDE UPDATE";

                    //$SQL2->UPDATE($Req2);
                }

                // REQUETE QUI V�RIFIE S'IL Y A UN SHIFT QUI COMMENCE TOUT DE SUITE APR�S

                $Req = "SELECT IDShift FROM shift WHERE IDInstallation = '" . $_POST['IDInstallation'] . "' && `Jour`='" . $_POST['FORMJour'] . "' && `Start`='" . $OldEnd . "' && `Semaine`='" . $Info['Semaine'] . "' && Assistant='" . $_POST['FORMAssistant'] . "'";
                $SQL->SELECT($Req);
                while ($Rep = $SQL->FetchArray()) {
                    $Queries[] = "UPDATE shift SET Start= " . $End . " WHERE IDShift=" . $Rep['IDShift'];
                    $LogArray[$Rep['IDShift']] = "RIGHT SIDE UPDATE";

                    //$SQL2->UPDATE($Req2);
                }
            }


            // REQUETE QUI V�RIFIE SI UN SHIFT ENGLOBE UN AUTRE AVANT AU COMPLET

            $Req = "SELECT IDShift FROM shift WHERE IDInstallation = '" . $_POST['IDInstallation'] . "' && `Jour`='" . $_POST['FORMJour'] . "' && `Start`='" . $Start . "' && `Semaine`='" . $Info['Semaine'] . "' && Assistant='" . $_POST['FORMAssistant'] . "' && IDShift<>'" . $IDShift . "'";
            $SQL->SELECT($Req);

            while ($Rep = $SQL->FetchArray()) {

                $Queries[] = "DELETE FROM shift WHERE IDShift='" . $Rep['IDShift'] . "'";
                $LogArray[$Rep['IDShift']] = "LEFT OVERLAP DELETE";

                //$SQL2->QUERY($Req2);
            }

            // REQUETE QUI V�RIFIE SI UN SHIFT ENGLOBE UN AUTRE APR�S AU COMPLET

            $Req = "SELECT IDShift FROM shift WHERE IDInstallation = '" . $_POST['IDInstallation'] . "' && `Jour`='" . $_POST['FORMJour'] . "' && `End`='" . $End . "'  && `Semaine`='" . $Info['Semaine'] . "'&& Assistant='" . $_POST['FORMAssistant'] . "' && IDShift<>'" . $IDShift . "'";
            $SQL->SELECT($Req);
            while ($Rep = $SQL->FetchArray()) {


                $Queries[] = "DELETE FROM shift WHERE `IDShift`='" . $Rep['IDShift'] . "'";
                $LogArray[$Rep['IDShift']] = "RIGHT OVERLAP DELETE";
                //$SQL2->QUERY($Req2);
            }


            $Req = "UPDATE shift SET
			Start=" . $Start . ",
			End=" . $End . ",
			Jour=" . $_POST['FORMJour'] . ",
			Assistant=" . $_POST['FORMAssistant'] . ",
			TXH=" . $_POST['FORMTXH'] . ",
			Salaire=" . $_POST['FORMSalaire'] . ",
			Commentaire='" . addslashes($_POST['FORMCommentaire']) . "',
			Warn='" . addslashes($_POST['FORMWarn']) . "',
			Message = '".addslashes($_POST['FORMMessage'])."',
			IDEmploye=" . $_POST['FORMIDEmploye'] . ",
			Confirme =" . $_POST['FORMConfirme'] . "
			WHERE IDShift=" . $IDShift;
            $Queries[] = $Req;


            //$SQL->QUERY($Req);

            $Queries[] = "UPDATE remplacement SET IDEmployeE = " . $_POST['FORMIDEmploye'] . "	WHERE IDShift = " . $IDShift;
            if ($Info['Semaine'] == $FirstWeek)
                $LogArray[$IDShift] = "UPDATE";
            else
                $LogArray[$IDShift] = "UPDATE BATCH";
            //$SQL->QUERY($Req);
            $Info['Semaine'] = get_next_sunday(0, $Info['Semaine']);
        }

        if ($NoError) {

            foreach ($LogArray as $IDShift => $Message) {
                $Log = new LogShift(new shift($IDShift), $Message);
            }

            $SQL = new sqlclass();
            foreach ($Queries as $Query) {


                $SQL->QUERY($Query);
            }

        } ELSE {
            echo 'il y a une erreur dans votre modification en batch...';
            echo "<br>";
            echo $ErrorStr;
            die();
        }
    }
}

?>


<script language=JAVASCRIPT>
    history.back(2);
</script>
