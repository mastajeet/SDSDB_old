<?PHP

//Cr�ation de la liste de mat�riel

function get_itemlist($Order = "Description")
{
    $SQL = new SQLClass();
    $Req = "SELECT IDItem, Description, Prix1, PrixForfait, NBForfait FROM item ORDER BY " . $Order . " ASC";
    $Ret = array();
    $SQL->SELECT($Req);
    while ($Rep = $SQL->FetchArray()) {
        $Ret[$Rep['IDItem']] = array('Description' => $Rep['Description'], 'Unitaire' => $Rep['Prix1'], 'Forfait' => $Rep['PrixForfait'], 'NBForfait' => $Rep['NBForfait']);
    }
    return $Ret;
}

function materielneeded($IDInspection)
{
    $current_inspection = new inspection($IDInspection);
    $Materiel = array();
    $Item = get_itemlist();


    $MaterielTrack = array();

    //Trousse de premiers soins
    $MaterielTrack[] = array('Champ' => 'Manuel', 'IDItem' => 1, 'Needed' => 1);
    $MaterielTrack[] = array('Champ' => 'Antiseptique', 'IDItem' => 2, 'Needed' => 20);
    $MaterielTrack[] = array('Champ' => 'Epingle', 'IDItem' => 3, 'Needed' => 24);
    $MaterielTrack[] = array('Champ' => 'Pansement', 'IDItem' => 4, 'Needed' => 24);
    $MaterielTrack[] = array('Champ' => 'BTria', 'IDItem' => 5, 'Needed' => 6);
    $MaterielTrack[] = array('Champ' => 'Gaze50', 'IDItem' => 6, 'Needed' => 4);
    $MaterielTrack[] = array('Champ' => 'Gaze100', 'IDItem' => 7, 'Needed' => 4);
    $MaterielTrack[] = array('Champ' => 'Ouate', 'IDItem' => 8, 'Needed' => 4);
    $MaterielTrack[] = array('Champ' => 'Gaze75', 'IDItem' => 9, 'Needed' => 12);
    $MaterielTrack[] = array('Champ' => 'Compressif', 'IDItem' => 10, 'Needed' => 4);
    $MaterielTrack[] = array('Champ' => 'Tape12', 'IDItem' => 11, 'Needed' => 1);
    $MaterielTrack[] = array('Champ' => 'Tape50', 'IDItem' => 12, 'Needed' => 1);
    $MaterielTrack[] = array('Champ' => 'Eclisses', 'IDItem' => 13, 'Needed' => 1);

    //Recommand�
    $MaterielTrack[] = array('Champ' => 'Ciseau', 'IDItem' => 14, 'Needed' => 1);
    $MaterielTrack[] = array('Champ' => 'Pince', 'IDItem' => 15, 'Needed' => 1);
    $MaterielTrack[] = array('Champ' => 'Masque', 'IDItem' => 16, 'Needed' => 1);
    $MaterielTrack[] = array('Champ' => 'Gant', 'IDItem' => 17, 'Needed' => 1);

    //Section Mat�riel
//	$MaterielTrack[] = array('Champ'=>'Verre','IDItem'=>18,'Needed'=>1);
//	$MaterielTrack[] = array('Champ'=>'Bousculade','IDItem'=>19,'Needed'=>1);

    if ($current_inspection->InspectionType == "Piscine") {
        $MaterielTrack[] = array('Champ' => 'Planche', 'IDItem' => 20, 'Needed' => 1);
    }
    $MaterielTrack[] = array('Champ' => 'Perche', 'IDItem' => 21, 'Needed' => 1);
    $MaterielTrack[] = array('Champ' => 'Couverture', 'IDItem' => 22, 'Needed' => 1);

    foreach ($MaterielTrack as $Rail) {
        $Materiel[$Rail['IDItem']] = getquantity($Rail['IDItem'], $current_inspection->$Rail['Champ'], $Rail['Needed']);
    }

    if ($current_inspection->InspectionType == "Piscine") {
        if ($current_inspection->Verre < 25)
            $Materiel[18] = array('Unitaire' => 1, 'Forfait' => 0);
        else
            $Materiel[18] = array('Unitaire' => 0, 'Forfait' => 0);
        if ($current_inspection->Bousculade < 25)
            $Materiel[19] = array('Unitaire' => 1, 'Forfait' => 0);
        else
            $Materiel[19] = array('Unitaire' => 0, 'Forfait' => 0);
    }

    return $Materiel;
}

function getquantity($IDItem, $Stock, $Needed)
{
    if ($Stock >= $Needed) {
        return array('Unitaire' => 0, 'Forfait' => 0);
    } else {
        $INFO = get_info('item', $IDItem);
        if (is_null($INFO['NBForfait'])) {
            return array('Unitaire' => $Needed - $Stock, 'Forfait' => 0);
        } else {
            //Prix sans forfait
            $OldPrix = ($Needed - $Stock) * $INFO['Prix1'];
            //Nombre de forfait n�ssaires
            $NBForfait = ceil(($Needed - $Stock) / $INFO['NBForfait']);
            $i = 1;
            while ($i <= $NBForfait) {
                $NewPrix = max(0, $Needed - $Stock - $INFO['NBForfait'] * $i) * $INFO['Prix1'] + $i * $INFO['PrixForfait'];
                if ($NewPrix > $OldPrix) {
                    return array('Unitaire' => max(0, $Needed - $Stock - $INFO['NBForfait'] * ($i - 1)), 'Forfait' => $i - 1);
                    $i = $NBForfait + 1;
                }
                $i++;
            }
            return array('Unitaire' => max(0, $Needed - $Stock - $INFO['NBForfait'] * ($NBForfait)), 'Forfait' => $NBForfait);
            //retourner avec la derniere quantit� roul�e
        }
    }
}

?>