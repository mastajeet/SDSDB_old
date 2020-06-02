<?PHP
if (isset($_GET['IDInspection'])) {
    $Inspection = new inspection($_GET['IDInspection']);
    if ($Inspection->Materiel == 1) {

        if (is_null($Inspection->IDFacture)) {
            $Semaine = get_last_sunday();
            $Item = get_itemlist();
            $Installation = new Installation($Inspection->IDInstallation);
            $QteMateriel = materielneeded($_GET['IDInspection']);
            $IDFacture = add_facture($Installation->Cote, $Semaine, 0, 'Facture de materiel - Inspection ' . get_vars('Boniyear'), '', 1, 1);
            $_GET['IDFacture'] = $IDFacture;
            $SQL->OpenConnection();
            foreach ($QteMateriel as $k => $v) {
                if ($Item[$k]['Unitaire'] == '' or is_null($Item[$k]['Unitaire']))
                    $Item[$k]['Unitaire'] = 0;
                if ($Item[$k]['Forfait'] == '' or is_null($Item[$k]['Forfait']))
                    $Item[$k]['Forfait'] = 0;

                if ($QteMateriel[$k]['Unitaire'] > 0) {
                    $Req = "INSERT INTO factsheet(`IDFacture`,`Start`,`End`,`Jour`,`TXH`,`Notes`) VALUES(" . $IDFacture . ",0," . $QteMateriel[$k]['Unitaire'] . ",0," . $Item[$k]['Unitaire'] . ",'" . addslashes($Item[$k]['Description']) . "')";
                    $SQL->INSERT($Req);
                }
                if ($QteMateriel[$k]['Forfait'] > 0) {
                    $Req = "INSERT INTO factsheet(`IDFacture`,`Start`,`End`,`Jour`,`TXH`,`Notes`) VALUES(" . $IDFacture . ",0," . $QteMateriel[$k]['Forfait'] . ",0," . $Item[$k]['Forfait'] . ",'" . addslashes($Item[$k]['Description']) . " - Forfait (x" . $Item[$k]['NBForfait'] . ")')";
                    $SQL->INSERT($Req);
                }
                $Req = "UPDATE inspection SET IDFacture = " . $IDFacture . " WHERE IDInspection = " . $_GET['IDInspection'];
                $SQL->Query($Req);
            }
            update_facture_balance($IDFacture);
        } else {
            $_GET['IDFacture'] = $Inspection->IDFacture;
        }
        $_GET['Section'] = "Display_Facture";
    } elseif ($Inspection->Materiel == 0) {
        $MainOutput->AddTexte('Le responsable n\'a pas confirme qu\'il desirait le materiel. Veuillez faire les modifications si necessaire dans le suivi des inspections', 'Titre');
    } elseif ($Inspection->Materiel == -1) {
        $MainOutput->AddTexte('Le responsable ne desire pas le materiel. Veuillez faire les modifications si necessaire dans le suivi des inspections', 'Titre');
    }

}
?>