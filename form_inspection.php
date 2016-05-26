<?PHP

$MainOutput->AddForm('Ajouter / Modifier une inspection');

if(!isset($_GET['IDInspection']) AND isset($_GET['IDInstallation'])){
	$current_inspection = new inspection(array('IDInstallation'=> $_GET['IDInstallation'],'DateI'=>time()));
    $MainOutput->InputHidden_Env('IDInstallation',$_GET['IDInstallation']);
}else{
    $current_inspection = new inspection($_GET['IDInspection']);
    $MainOutput->InputHidden_Env('IDInstallation',$current_inspection->IDInstallation);
}

if($current_inspection->DateI=="" OR is_null($current_inspection->DateI))
    $current_inspection->DateI=$current_inspection->DateP;


$MainOutput->InputHidden_Env('Action','Inspection');
$MainOutput->InputHidden_Env('IDInspection',$_GET['IDInspection']);


 
$MainOutput->OpenRow();
$MainOutput->OpenCol('550');
	$MainOutput->AddTexte('<img src=carlos.gif width=550 height=1>');
$MainOutput->CloseCol();
$MainOutput->OpenCol('50');
	$MainOutput->AddTexte('<img src=carlos.gif width=50 height=1>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('<u>Information Générale</u>
	
	','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE !Cessation ORDER BY Nom ASC";



$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->OpenTable();

$MainOutput->inputselect('IDEmploye',$Req,$current_inspection->IDEmploye,'Inspecteur');
$MainOutput->inputselect('IDResponsable',get_responsable_client($current_inspection->IDInstallation),$current_inspection->IDResponsable,'Contact');
$MainOutput->InputTime('DateI','Date de l\'inspection',$current_inspection->DateI,array('Date'=>TRUE,'Time'=>False));

$MainOutput->CloseTable();
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('<hr>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

if($current_inspection->InspectionType=="Piscine") {

    $MainOutput->OpenRow();
    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte('<u>Matériel de piscine</u>

        ', 'Titre');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();
    $MainOutput->flag('Mirador', $current_inspection->Mirador, 'Mirador (Si la piscine est plus grande que 150m2)');
    $MainOutput->flag('SMU', $current_inspection->SMU, 'Moyen de communication pour les SMU à moins de 100m et facilement accessible');
    $MainOutput->flag('Procedures', $current_inspection->Procedures, 'Les procédures d\'urgences sont affichées près du moyen de communication');
    $MainOutput->flag('Perche', $current_inspection->Perche, 'Perche isolée électriquement de 3.6m');
    $MainOutput->flag('Bouees', $current_inspection->Bouees, 'Deux bouées de sauvetage
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a) annulaires entre 275 et 380mm de diamètre
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;avec cordage de 3m + ½ largeur de la piscine
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OU b) Bouée torpille avec 2m de cordage et une bandouillère');
    $MainOutput->flag('Planche', $current_inspection->Planche, 'Planche dorsale');
    $MainOutput->flag('Couverture', $current_inspection->Couverture);
    $MainOutput->flag('Registre', $current_inspection->Registre, 'Registre des installations');
    $MainOutput->flag('Chlore', $current_inspection->Chlore, 'Trousse de vérification de Chlore et pH');
    $MainOutput->textarea('NotesMateriel', 'Notes', 25, 5, $current_inspection->NotesMateriel);


    $MainOutput->OpenRow();
    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte('<hr>');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte('
        <u>Affichage</u>

        ', 'Titre');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    $MainOutput->OpenRow();
    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte('Pronfondeur de l\'eau (en 100mm) aux points suivants:', 'Titre');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    $MainOutput->InputText('ProfondeurPP', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Peu profond (en mm)', 3, $current_inspection->ProfondeurPP);
    $MainOutput->InputText('ProfondeurP', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Profond (en mm)', 3, $current_inspection->ProfondeurP);
    $MainOutput->InputText('ProfondeurPente', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Pente (en mm)', 3, $current_inspection->ProfondeurPente);

    $MainOutput->Flag('Cercle', $current_inspection->Cercle, 'Cercle noir de 150 mm de diamètre au point le plus profond de la piscine');

    $MainOutput->OpenRow();
    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte('Règlements (en 25mm) - ou pictogramme', 'Titre');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();


    $MainOutput->InputText('Verre', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Aucun contenant de verre (en mm)', 3, $current_inspection->Verre);
    $MainOutput->InputText('Bousculade', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Pas de bousculade (en mm)', 3, $current_inspection->Bousculade);

    $MainOutput->InputText('Maximum', 'Nombre maximum de baigneurs (en 150mm)', 3, $current_inspection->Maximum);
    $MainOutput->textarea('NotesAffichage', 'Notes', 25, 5, $current_inspection->NotesAffichage);
    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte('<hr>');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte('
        <u>Construction</u>

        ', 'Titre');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    $MainOutput->Flag('EchellePP', $current_inspection->EchellePP, 'Une échelle / escalier dans la partie peu profonde si la profondeur dépasse 600mm');
    $MainOutput->Flag('EchelleX2P', $current_inspection->EchelleX2P, 'Une échelle de chaque côté de la partie profonde');
    $MainOutput->Flag('Escalier', $current_inspection->Escalier, 'S\'il y a un estcalier, le nez de la marche doit être peint de couleur contrastante');
    $MainOutput->Flag('Cloture12', $current_inspection->Cloture12, 'La piscine doit être entourée d\'une clôture d\'un minimum de 1,20m');
    $MainOutput->Flag('Cloture100', $current_inspection->Cloture100, 'La clôture ne doit pas permettre de faire passer un cercle de 100mm de diamètre');
    $MainOutput->Flag('Maille38', $current_inspection->Maille38, 'S\'il s\'agit d\'une clôture de maille, la maille doit être inférieure à 38mm');
    $MainOutput->Flag('Promenade', $current_inspection->Promenade, 'Si une partie de la promenade peut être utilisée hors des heures d\'ouverture, une clôture de 900mm doit séparer la promenade de la partie réservée de la piscine');
    $MainOutput->Flag('Fermeacle', $current_inspection->Fermeacle, 'Toutes les ouvertures qui donnent accès à la piscine doivent être fermées à clef lorsque la piscine est sans surveillance');
    $MainOutput->textarea('NotesConstruction', 'Notes', 25, 5, $current_inspection->NotesConstruction);

}elseif($current_inspection->InspectionType=="Plage"){

    $MainOutput->OpenRow();
    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte('<u>Matériel de piscine</u>

    ','Titre');

    $MainOutput->CloseCol();
    $MainOutput->CloseRow();
    $MainOutput->flag('Mirador', $current_inspection->Mirador, 'Mirador de 2,4m de hauteur pour chaque unité ou fraction d\'unité de 125m linéaires de plage');
    $MainOutput->flag('LigneBouee', $current_inspection->LigneBouee, 'Une ligne de bouées de couleur blanche indiquant les limites de la zone de surveillance.
    Profondeur maximale : 1,6m');
    $MainOutput->flag('Bouees', $current_inspection->Bouees, 'Pour chaque mirador : une bouée de sauvetage
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a) annulaire entre 275 et 380mm avec 15m de corde
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ou b) torpille avec 2m de corde et une boucle pour les épaules');
    $MainOutput->flag('Couverture', $current_inspection->Couverture);
    $MainOutput->flag('SMU', $current_inspection->SMU, 'Moyen de communication pour les SMU à moins de 100m et facilement accessible');
    $MainOutput->flag('Procedures', $current_inspection->Procedures, 'Les procédures d\'urgences sont affichées près du moyen de communication');
    $MainOutput->flag('Registre', $current_inspection->Registre, 'Registre des installations');
    $MainOutput->flag('BoueeProfond', $current_inspection->BoueeProfond, 'Une bouée indicant au point le plus profond de la zone pour chaque unité ou fraction d\'unité de 125m linéaires de plage en caractère de 150mm en couleur contrastante lisible de la plage');
    $MainOutput->flag('Chaloupe', $current_inspection->Chaloupe, 'Chaloupe de sauvetage pour chaque unité ou fraction d\'unité de 250m linéaires de plage.
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sauf si :
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;i. la plage est entourée d\'un quai dont la plus grande dimension est inférieure à 75m
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ii. La distance entre la plage et la ligne de bouée est inférieure à 50m s\'il y a des postes de surveillance
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;qui sont situés à l\'extérieure de la ligne de bouées dans la zone la plus profonde.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    cependant :

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    a) Un aquaplane peut remplacer lachaloupe lorsque la distance entre		les bouées et la rive est supérieure
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     à 		50m s\'il y a des postes de 			surveillance situés à l\'extérieur des		lignes de bouées dans la zone la
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     plus profonde

    ');
    $MainOutput->openrow();
    $MainOutput->opencol();
    $MainOutput->addtexte('La chaloupe doit contenir:','Titre');
    $MainOutput->closecol();
    $MainOutput->closerow();

    $MainOutput->flag('ChaloupeRame', $current_inspection->ChaloupeRame, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a) 2 rames et tolets');
    $MainOutput->flag('ChaloupeAncre', $current_inspection->ChaloupeAncre, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b) Une bouée d\'amarrage ou un ancre');
    $MainOutput->flag('ChaloupeGilets', $current_inspection->ChaloupeGilets, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c) 3 gilets de sauvetage conforme');
    $MainOutput->flag('ChaloupeBouee', $current_inspection->ChaloupeBouee, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d) Une bouée annulaire d\'un diamètre intérieur maximal de 380mm et de 15m de corde');

    $MainOutput->flag('Chaloupe', $current_inspection->Chaloupe, 'Registre des installations');
    $MainOutput->textarea('NotesMateriel', 'Notes', 25, 5, $current_inspection->NotesMateriel);
    $MainOutput->OpenRow();
    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte('<hr>');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();
    $MainOutput->OpenRow();
    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte('
        <u>Affichage</u>

        ', 'Titre');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();


    $MainOutput->OpenRow();
    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte('Deux affiches placées en évidence écrite en caractères d\'une grandeur minimale de 25mm comportant les règlements suivants', 'Titre');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();


    $MainOutput->InputText('Verre', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Aucun contenant de verre (en mm)', 3, $current_inspection->Verre);
    $MainOutput->InputText('Canotage', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Pas de bousculade (en mm)', 3, $current_inspection->Canotage);


    $MainOutput->OpenRow();
    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte(' Des affiches aux extrémité de la plage et sur la limite des terrains adjacents à des intervalles maximales de 60m comportant les indications suivantes:', 'Titre');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    $MainOutput->Flag('HeureSurveillance', $current_inspection->HeureSurveillance, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	i. Les heures de surveillance	');
    $MainOutput->Flag('LimitePlage', $current_inspection->LimitePlage, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ii. La limite de la plage sous surveillance');

    $MainOutput->OpenRow();
    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte('<hr>');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();

    $MainOutput->OpenRow();
    $MainOutput->OpenCol('100%', 2);
    $MainOutput->AddTexte('
        <u>Préposés à la surveillance</u>

        ', 'Titre');
    $MainOutput->CloseCol();
    $MainOutput->CloseRow();
    $options = [
            0=>'- de 125m',
            1=>'125m a 250m',
            2=>'250m a 375m',
            3=>'375m a 500m',
            4=>'500m a 625m'
        ];
    $MainOutput->InputSelect('LongueurPlage',$options,$current_inspection->LongueurPlage, 'Longueur de la plage');
}
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%', 2);
$MainOutput->AddTexte('<hr>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('
	<u>Trousse de premiers soins</u>
	
	','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('<u>Obligatoire</u>
		','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->InputText('Manuel','Manuel de secourisme',2,$current_inspection->Manuel);
$MainOutput->InputText('Antiseptique','150ml d\'antiseptique OU 20 tampons d\'alcool',2,$current_inspection->Antiseptique);
$MainOutput->InputText('Epingle','24 épingles de sûreté',2,$current_inspection->Epingle);
$MainOutput->InputText('Pansement','24 pansements adhésifs enveloppés séparément',2,$current_inspection->Pansement);
$MainOutput->InputText('BTria','6 bandages triangulaires',2,$current_inspection->BTria);
$MainOutput->InputText('Gaze50','4 rouleaux de bandage de gaze de 50mm',2,$current_inspection->Gaze50);
$MainOutput->InputText('Gaze100','4 rouleaux de bandage de gaze de 100mm',2,$current_inspection->Gaze100);
$MainOutput->InputText('Ouate','4 paquets de Ouate de 25g chacun',2,$current_inspection->Ouate);
$MainOutput->InputText('Gaze75','12 tampons ou compresses de gaze de 75 x 75mm',2,$current_inspection->Gaze75);
$MainOutput->InputText('Compressif','4 tampons chirurgicaux pour pansements compressifs enveloppés séparément',2,$current_inspection->Compressif);
$MainOutput->InputText('Tape12','1 rouleau de diachylon de 12 mm de largeur',2,$current_inspection->Tape12);
$MainOutput->InputText('Tape50','1 rouleau de diachylon de 50 mm de largeur',2,$current_inspection->Tape50);
$MainOutput->InputText('Eclisses','Éclisses de grandeur assorties ou QuickSplint',2,$current_inspection->Eclisses);

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('
	<u>Fortement recommandé</u>
		','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->InputText('Ciseau','Ciseaux',2,$current_inspection->Ciseau);
$MainOutput->InputText('Pince','Pinces à écharde',2,$current_inspection->Pince);
$MainOutput->InputText('Crayon','Crayon',2,$current_inspection->Crayon);
$MainOutput->InputText('Masque','Masque de poche',2,$current_inspection->Masque);
$MainOutput->InputText('Gant','Gants chirurgicaux',2,$current_inspection->Gant);


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('<hr>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


$MainOutput->FormSubmit('Ajouter / Modifier');






echo $MainOutput->Send(1);

?>