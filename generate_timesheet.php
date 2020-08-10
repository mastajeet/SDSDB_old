<?PHP
if(!isset($_GET['ToPrint'])){
	$_GET['ToPrint'] = FALSE;
	}
if(!isset($_GET['Semaine'])){
	$_GET['Semaine'] = get_last_sunday();
	}
if(!isset($_GET['ENR'])){
	$_GET['ENR'] = FALSE;
	}
	if($_GET['ENR']){
			$Req = "DELETE FROM timesheet WHERE IDPaye = '".$IDPaye."'";
			$SQL->query($Req);
	}

$TestOutput = new HTMLContainer;
$SQL3 = new sqlclass;
$S1 = $_GET['Semaine'];
$S2 = get_next_sunday(0,$S1);
	
$SQL = new sqlclass;
$SQL2 = new sqlclass;
//	$Req = "
//SELECT DISTINCT employe.IDEmploye, Nom, Prenom, Salaire, SalaireA, SalaireS, shift.Assistant, Semaine
//FROM shift
//JOIN employe ON shift.IDEmploye = employe.IDEmploye
//WHERE (semaine = '".$S1."' OR semaine = '".$S2."') and employe.IDEmploye<>0
//GROUP BY shift.IDEmploye, Assistant, Salaire
//ORDER BY shift.IDEmploye ASC
//";


$Req = "
SELECT DISTINCT employe.IDEmploye, shift.Assistant, Semaine, Salaire
FROM shift
JOIN employe ON shift.IDEmploye = employe.IDEmploye
WHERE (semaine = '".$S1."' OR semaine = '".$S2."') and employe.IDEmploye<>0
GROUP BY shift.IDEmploye, Assistant, Salaire
ORDER BY shift.IDEmploye ASC
";

$SQL->SELECT($Req);

while($Rep = $SQL->FetchArray()) {

    $VALUE = "";

    $employe = new Employee($Rep['IDEmploye']);


    $Salaire = "";
    if ($Rep['Salaire'] == 0) {
        if ($Rep['Assistant'] == 1) {
            $Salaire = $employe->SalaireA;
        } else {
            $Salaire = $employe->SalaireS;
        }
    } else {
        $Salaire = $Rep['Salaire'];
    }


    for ($i = 0; $i <= 6; $i++) {
        $Req2 = "SELECT sum(End-Start), Confirme FROM shift WHERE IDEmploye = '" . $employe->IDEmploye . "' && abs(Salaire-" . $Rep['Salaire'] . ")<0.01 && Assistant='" . $Rep['Assistant'] . "' && Semaine='" . $S1 . "' && Jour='$i' GROUP BY IDEmploye";
        $SQL2->SELECT($Req2);
        $Rep2 = $SQL2->FetchArray();
        $NBH = round($Rep2[0] / 3600, 2);
        $VALUE = $VALUE . " '" . $NBH . "',";
    }


    for ($i = 0; $i <= 6; $i++) {
        $Req2 = "SELECT sum(End-Start), Confirme FROM shift WHERE IDEmploye = '" . $employe->IDEmploye . "' && abs(Salaire-" . $Rep['Salaire'] . ")<0.01 && Assistant='" . $Rep['Assistant'] . "' && Semaine='" . $S2 . "' && Jour='$i' GROUP BY IDEmploye";
        $SQL2->SELECT($Req2);
        $Rep2 = $SQL2->FetchArray();
        $NBH = round($Rep2[0] / 3600, 2);
        if (!$_GET['ToPrint']) {
            $VALUE = $VALUE . " '" . $NBH . "',";
        }
    }


    if ($_GET['ENR']) {
        $Req3 = "INSERT INTO timesheet(`IDEmploye`,`Salaire`, `IDPaye`,`S10`,`S11`,`S12`,`S13`,`S14`,`S15`,`S16`,`S20`,`S21`,`S22`,`S23`,`S24`,`S25`,`S26`) VALUES('" . $employe->IDEmploye . "','" . $Salaire . "','" . $IDPaye . "'," . substr($VALUE, 0, -1) . ")";
        $SQL3->insert($Req3);
    }

}

if($_GET['ENR']){
    $Req = "UPDATE shift SET `Paye`='TRUE' WHERE Semaine = '".$_GET['Semaine']."'";
    $SQL->query($Req);
    $MainOutput->emptyoutput();
    $_GET['FORMIDPaye']=$IDPaye;
    include('display_timesheet.php');
}else{
    echo $MainOutput->send(1);
}