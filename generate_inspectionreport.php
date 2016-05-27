<?PHP


if(isset($_GET['IDInspection'])){
$NMois = get_month_list();
	$current_inspection = new inspection($_GET['IDInspection']);
	if($current_inspection->InspectionType=="Piscine"){
		$MaterielTrack = array();
		$MaterielTrack['Mirador'] = "Comme votre piscine à plus de 150m2, il est obligatoire d'avoir un mirador";
		$MaterielTrack['SMU'] = "La sauveteur doit avoir accès a un moyen de communication avec les services médicaux d'urgence, il est nécessaire de mettre un téléphone à la disposition du sauveteur";
		$MaterielTrack['Procedures'] = "Les procédures d'urgences doivent être affichées près du moyen de communication";
		$MaterielTrack['Perche'] = "Une perche isolée électriquement doit être mise à la disposition du sauveteur";
		$MaterielTrack['Bouees'] = "2 bouées de sauvetages de 275mm à 380mm de largeur avec un cordage de 3m + largeur de la piscine doivent être mises à la disposition du sauveteur (ou une Bouée torpille avec 2m de cordage et bandouilère";
		$MaterielTrack['Planche'] = "La planche dorsale fait partie du matériel obligatoire à détenir sur le bord d'une piscine";
		$MaterielTrack['Couverture'] = "Une couverture doit se trouver à la piscine";
		$MaterielTrack['Registre'] = "Un registre des installation doit se trouver à la piscine";
		$MaterielTrack['Chlore'] = "Le sauveteur doit avoir du matériel pour faire les tests d'eau (Chlore et pH)";

		$AffichageTrack = array();
		$AffichageTrack['ProfondeurPP'] = array('Message'=>"La profondeur de la piscine au peu profond doit être inscrite en caractère d'au moins 100mm de haut",'Taille'=>100);
		$AffichageTrack['ProfondeurP'] = array('Message'=>"La profondeur de la piscine au profond doit être inscrite en caractère d'au moins 100mm de haut",'Taille'=>100);
		$AffichageTrack['ProfondeurPente'] = array('Message'=>"La profondeur de la piscine dans le milieu de la pente doit être inscrite en caractère d'au moins 100mm de haut",'Taille'=>100);
		$AffichageTrack['Cercle'] = array('Message'=>"Un cercle noir d'un diamètre d'au moins 150mm doit être dessiné au point le plus profond de la piscine",'Taille'=>1);
		$AffichageTrack['Verre'] = array('Message'=>"Le règlement \"Interdiction de contenants de vitre\" doit être écrit en un caractère d'au moins 25mm de haut - Un pictogramme est équivalent",'Taille'=>25);
		$AffichageTrack['Bousculade'] = array('Message'=>"Le règlement \"Bousculade Interdite\" doit être écrit en un caractère d'au moins 25mm de haut - Un pictogramme est équivalent",'Taille'=>25);
		$AffichageTrack['Maximum'] = array('Message'=>"Le nombre maximum de baigneur de votre piscine doit être écrit en lettres d'au moins 150mm",'Taille'=>150);

		$ConstructionTrack = array();
		$ConstructionTrack['EchellePP'] = "Le peu profond de la piscine doit être accessible via une échelle ou des escaliers";
		$ConstructionTrack['EchelleX2P'] = "Une échelle de chaque partie du profond doit être installée";
		$ConstructionTrack['Escalier'] = "Le nez des marches du peu profond doivent être peinturés d'une couleur contrastante";
		$ConstructionTrack['Cloture12'] = "La clôture entourant la piscine doit au minimum avoir 1.20m de hauteur";
		$ConstructionTrack['Cloture100'] = "La clôture entourant la piscine ne doit pas faire passer d'objet de plus de 100mm de diamètre";
		$ConstructionTrack['Maille38'] = "La maille de la clôture doit être inférieure à 38mm";
		$ConstructionTrack['Promenade'] = "La promenade accessible lorsque la piscine est fermée doit avoir une clôture d'au moins 900mm de hauteur";
		$ConstructionTrack['Fermeacle'] = "Il doit être possible de verrouiller les points d'accès à la piscine lorsque celle-ci est fermée";
		$Obligatoire = array(1,2,3,4,5,6,7,8,9,10,11,12,13,18,19,20,21);
	}elseif($current_inspection->InspectionType=="Plage"){
		$MaterielTrack = array();
		$MaterielTrack['Mirador'] = "Un mirador de 2.4m de haut doit etre installe pour chaque unité ou fraction d'unité de 125m linéaire de plage";
		$MaterielTrack['SMU'] = "La sauveteur doit avoir accès a un moyen de communication avec les services médicaux d'urgence, il est nécessaire de mettre un téléphone à 100m du poste de surveillance";
		$MaterielTrack['Procedures'] = "Les procédures d'urgences doivent être affichées près du moyen de communication";
		$MaterielTrack['Couverture'] = "Une couverture doit se trouver au poste de surveillance";
		$MaterielTrack['Registre'] = "Un registre des installation doit se trouver au poste de surveillance";
		$MaterielTrack['Bouees'] = "2 bouées de sauvetages de 275mm à 380mm de largeur avec un cordage de 15m (ou une bouée torpille avec 2m de cordage et boucle pour les épaules)";
		$MaterielTrack['Chaloupe'] = "Une chaloupe par unité ou fraction d'unité de 250m linéaire de plage doit etre mise à la disposition du sauveteur";
		$MaterielTrack['ChaloupeRame'] = "Vous devez avoir 2 rames et tolets pour la chaloupe";
		$MaterielTrack['ChaloupeAncre'] = "Vous devez avoir une bouée d'amarrage ou un ancre pour la chaloupe";
		$MaterielTrack['ChaloupeGilets'] = "Vous devez avoir 3 gilets de sauvetages conformes pour la chaloupe";
		$MaterielTrack['ChaloupeBouee'] = "Vous devez avoir une bouée annulaire d'un diamètre intérieur maximal de 380mm et 15m de corde pour la chaloupe";
		$MaterielTrack['LigneBouee'] = "Une ligne de bouées de couleur blanche indiquant les limites de la zone de surveillance doit etre installée";
		$MaterielTrack['BoueeProfond'] = "Une bouée indicant le point le plus profond doit être installée pour chaque 125m linéaires de plage et l'écriture doit avoir au moins 150mm et doit être d'une couleur contrastante";

		$AffichageTrack = array();
		$AffichageTrack['Verre'] = array('Message'=>"Le règlement \"Pas de contenant de verre\" doit être écrit en un caractère d'au moins 25mm de haut sur deux affiches placées en évidence",'Taille'=>25);
		$AffichageTrack['Canotage'] = array('Message'=>"Le règlement \"Le canotage et la peche sont interdites dans la zone de baignade\"  doit être écrit en un caractère d'au moins 25mm de haut sur deux affiches placées en évidence",'Taille'=>25);
		$AffichageTrack['HeureSurveillance'] = array('Message'=>"Une affiche comportant les heures de surveilance doit etre affichée aux limites des terrains adjacents et a des intervalles maximales de 60m",'Taille'=>1);
		$AffichageTrack['LimitePlage'] = array('Message'=>"Une affiche comportant les limites de la zone surveillées doit etre affichée aux limites des terrains adjacents et a des intervalles maximaux de 60m.",'Taille'=>1);

		$Obligatoire = array(1,2,3,4,5,6,7,8,9,10,11,12,13,21);
	}
	
	$QteMateriel = materielneeded($_GET['IDInspection']);
	$NBItem =0;
	
	foreach($Obligatoire as $i){
		$NBItem = $NBItem + $QteMateriel[$i]['Unitaire']+$QteMateriel[$i]['Forfait'];
	}
	$Item = get_itemlist();
	$current_installation = new installation($current_inspection->IDInstallation);
	$INFOE = get_info('employe',$current_inspection->IDEmploye);
	$INFOR = get_info('responsable',$current_inspection->IDResponsable);
	$Date = getdate($current_inspection->DateI);
	
	$MainOutput->OpenTable('600');
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
	
	
	$MainOutput->AddTexte("Sillery, le ".$Date['mday']." ".$NMois[$Date['mon']]." ".$Date['year']."
 
 
 
 	Bonjour ".strtolower($INFOR['Titre'])." ".ucfirst($INFOR['Nom']).",
	
	",'Titre');

	
	$Date = getdate($current_inspection->DateI);
	$MainOutput->AddTexte("Suite à l'inspection de votre ".strtolower($current_inspection->InspectionType)." (".$current_installation->Nom.") effectuée le ".$Date['mday']." ".$NMois[$Date['mon']]." ".$Date['year']." par ".$INFOE['Prenom']." ".$INFOE['Nom'].",  nous désirons vous informer qu'en vertu du règlement sur les bains publics LRQ S-3, r-3, vous devrez apporter certains correctifs afin d'avoir des installations conformes. Voici un descriptif des correctifs que nous vous suggérons.");
	$MainOutput->br(2);
	$MainOutput->AddTexte('Matériel','Titre');
	$MainOutput->br(2);
	foreach($MaterielTrack as $k => $v){
	
		$Prob = false;
		if(!$current_inspection->$k){
			$MainOutput->AddTexte(" - ".$v);
			$MainOutput->br();
			$Prob = true;
		}
	}
	
	if($current_inspection->NotesMateriel<>""){
			$MainOutput->AddTexte(" - ".$current_inspection->NotesMateriel);
			$MainOutput->br();	
	}
	
			if($NBItem==0){
			$MainOutput->AddTexte(" - Votre ".strtolower($current_inspection->InspectionType)." répond à toutes les exigences concernant le matériel");
			$MainOutput->br();
		}else{
			$MainOutput->AddTexte(" - Votre trousse de premiers soins n'est pas complète, veuillez voir les détails plus bas");
			$MainOutput->br();
		}
		

	
	$MainOutput->br();
	$MainOutput->AddTexte('Affichage','Titre');
	$MainOutput->br(2);
	$Prob = false;
	Foreach($AffichageTrack as $k => $v){
		if($current_inspection->$k<$v['Taille']){
			$MainOutput->AddTexte(" - ".$v['Message']);
			$MainOutput->br();
			$Prob = true;
		}
		
	}
	if($current_inspection->NotesAffichage<>""){
			$MainOutput->AddTexte(" - ".$current_inspection->NotesAffichage);
			$MainOutput->br();	
	}
	if(!$Prob){
			$MainOutput->AddTexte(" - Votre ".strtolower($current_inspection->InspectionType)." répond à toutes les exigences concernant de l'affichage");
			$MainOutput->br();
	}
	
	
	
	if($current_inspection->InspectionType=="Piscine") {
		$MainOutput->br();
		$MainOutput->AddTexte('Construction', 'Titre');
		$MainOutput->br(2);
		$Prob = false;
		foreach ($ConstructionTrack as $k => $v) {
			if (!$current_inspection->$k) {
				$MainOutput->AddTexte(" - " . $v);
				$MainOutput->br();
				$Prob = true;
			}
		}
		if (!$Prob) {
			$MainOutput->AddTexte(" - Votre piscine répond à toutes les exigences concernant de la construction");
			$MainOutput->br();
		}

		if ($current_inspection->NotesConstruction <> "") {
			$MainOutput->AddTexte(" - " . $current_inspection->NotesConstruction);
			$MainOutput->br();
		}
	}elseif($current_inspection->InspectionType=="Plage"){

		$NBRessource = array(
			0=>"1 Surveillant-Sauveteur",
			1=>"2 Surveillant-Sauveteurs et 1 Assistant",
			2=>"2 Surveillant-Sauveteurs et 2 Assistants",
			3=>"3 Surveillant-Sauveteurs et 2 Assistants",
			4=>"3 Surveillant-Sauveteurs et 3 Assistants",
		);

		$MainOutput->br();
		$MainOutput->AddTexte('Votre plage doit avoir '.$NBRessource[$current_inspection->LongueurPlage]);
		$MainOutput->br(2);
	}
	
	$MainOutput->br();
	$MainOutput->AddTexte('Achat de matériel','Titre');
	$MainOutput->br();
	$MainOutput->AddTexte('Le service de sauveteur est en mesure de vous vendre les éléments manquants afin que vous soyez conformes au règlement. Voici la liste ainsi que les prix rattachés aux items nécessaires. S\'ajoutent à ces prix les taxes de ventes applicables.');
	$MainOutput->br(2);
	$MainOutput->OpenTable();
	$MainOutput->OpenRow();
	
	$MainOutput->OpenCol('230');
		$MainOutput->AddTexte('Item','Titre');
	$MainOutput->CloseCol();
	
	$MainOutput->OpenCol('30');
		$MainOutput->AddTexte('<div align=center>Qte</div>','Titre');
	$MainOutput->CloseCol();
	
	$MainOutput->OpenCol('120');
		$MainOutput->AddTexte('<div align=center>Prix</div>','Titre');
	$MainOutput->CloseCol();
	
	$MainOutput->OpenCol('120');
		$MainOutput->AddTexte('<div align=center>Sous-Total</div>','Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',5);
		$MainOutput->AddOutput("<hr>");
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$Total = 0;
	foreach($QteMateriel as $k=>$v){
		if($QteMateriel[$k]['Unitaire']>0){

			$MainOutput->OpenRow();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte($Item[$k]['Description']);
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.$QteMateriel[$k]['Unitaire']);
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($Item[$k]['Unitaire'],2)." $");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($Item[$k]['Unitaire']*$QteMateriel[$k]['Unitaire'],2)." $",'Titre');
			$MainOutput->CloseCol();
		
			$Total = $Total+$Item[$k]['Unitaire']*$QteMateriel[$k]['Unitaire'];
			$MainOutput->CloseRow();

		}
		
		if($QteMateriel[$k]['Forfait']>0){

			$MainOutput->OpenRow();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte($Item[$k]['Description']." - Forfait (x".$Item[$k]['NBForfait'].")");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.$QteMateriel[$k]['Forfait']);
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($Item[$k]['Forfait'],2)." $");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($Item[$k]['Forfait']*$QteMateriel[$k]['Forfait'],2)." $",'Titre');
			$MainOutput->CloseCol();
				
			$MainOutput->CloseRow();
			$Total = $Total+$Item[$k]['Forfait']*$QteMateriel[$k]['Forfait'];
		}
	
	}
		$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',5);
		$MainOutput->AddOutput("<hr>");
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	
			$MainOutput->OpenRow();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=right>'."Sous-Total",'Titre');
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($Total,2)." $");
			$MainOutput->CloseCol();
				
			$MainOutput->CloseRow();
			
			
			
			
			
			
			
			
			/**
			
			
			
			$MainOutput->OpenRow();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=right>'.'TPS ('.get_vars('TPS').'%)','Titre');
			$MainOutput->CloseCol();
			$TPS = $Total*get_vars('TPS');
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($TPS,2)." $");
			$MainOutput->CloseCol();
				
			$MainOutput->CloseRow();
			
	
	
			$MainOutput->OpenRow();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=right>'.'TVQ ('.get_vars('TVQ').'%)','Titre');
			$MainOutput->CloseCol();
			$TVQ = ($Total+$TPS)*get_vars('TVQ');
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($TVQ,2)." $");
			$MainOutput->CloseCol();
				
			$MainOutput->CloseRow();
			
			$MainOutput->OpenRow();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte("&nbsp;");
			$MainOutput->CloseCol();
			
			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=right>'.'Total','Titre');
			$MainOutput->CloseCol();

			$MainOutput->OpenCol();
				$MainOutput->AddTexte('<div align=center>'.number_format($Total+$TPS+$TVQ,2)." $");
			$MainOutput->CloseCol();
				
			$MainOutput->CloseRow();
	**/
	
		$MainOutput->CloseTable();
	
	
	
	
	$MainOutput->br();
	$MainOutput->AddTexte("Ce rapport d'observation a été effectué à la date mentionnée ci-dessus.  Tout changement survenu par la suite n'est pas mentionné.  Le personnel de Service de Sauveteurs qn inc vous tiendra informé du manque de matériel, des bris ou autres anomalies en cours d'été.  Nous vous remercions de bien vouloir procéder aux correctifs nécessaires afin que vous puissiez avoir des installations conformes.  Si vous avez des questions ou besoin de précisions, n'hésitez pas à communiquer avec nous au (418) 687-4047.");
	
	
	$MainOutput->br(3);
	$MainOutput->AddTexte("___________________________________");
	$INFOW = get_info('employe',$_COOKIE['IDEmploye']);
	$MainOutput->br();
	$MainOutput->AddTexte($INFOW['Prenom']." ".$INFOW['Nom'],'Titre');
	
	
	
	
	
	
	
	
	
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->CloseTable();
	
	
}else{
	include('inspection.php');
}


echo $MainOutput->Send(1);


?>