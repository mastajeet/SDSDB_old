<?PHP


if(isset($_GET['IDInspection'])){
$NMois = get_month_list();
	$INFO = get_info('inspection',$_GET['IDInspection']);
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
	
	
	$QteMateriel = materielneeded($_GET['IDInspection']);
	$NBItem =0;
	$Obligatoire = array(1,2,3,4,5,6,7,8,9,10,11,12,13,18,19,20,21);
	foreach($Obligatoire as $i){
		$NBItem = $NBItem + $QteMateriel[$i]['Unitaire']+$QteMateriel[$i]['Forfait'];
	}
	$Item = get_itemlist();
	$INFOP = get_info('installation',$INFO['IDInstallation']);
	$INFOE = get_info('employe',$INFO['IDEmploye']);
	$INFOR = get_info('responsable',$INFO['IDResponsable']);
	$Date = getdate($INFO['DateI']);
	
	$MainOutput->OpenTable('600');
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
	
	
	$MainOutput->AddTexte("Sillery, le ".$Date['mday']." ".$NMois[$Date['mon']]." ".$Date['year']."
 
 
 
 	Bonjour ".strtolower($INFOR['Titre'])." ".ucfirst($INFOR['Nom']).",
	
	",'Titre');

	
	$Date = getdate($INFO['DateI']);
	$MainOutput->AddTexte("Suite à l'inspection de votre piscine (".$INFOP['Nom'].") effectuée le ".$Date['mday']." ".$NMois[$Date['mon']]." ".$Date['year']." par ".$INFOE['Prenom']." ".$INFOE['Nom'].",  nous désirons vous informer qu'en vertu du règlement sur les bains publics LRQ S-3, r-3, vous devrez apporter certains correctifs afin d'avoir des installations conformes. Voici un descriptif des correctifs que nous vous suggérons.");
	$MainOutput->br(2);
	$MainOutput->AddTexte('Matériel','Titre');
	$MainOutput->br(2);
	foreach($MaterielTrack as $k => $v){
	
		$Prob = false;
		if(!$INFO[$k]){
			$MainOutput->AddTexte(" - ".$v);
			$MainOutput->br();
			$Prob = true;
		}
	}
	
	if($INFO['NotesMateriel']<>""){
			$MainOutput->AddTexte(" - ".$INFO['NotesMateriel']);
			$MainOutput->br();	
	}
	
			if($NBItem==0){
			$MainOutput->AddTexte(" - Votre piscine répond à toutes les exigences concernant le matériel");
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
		if($INFO[$k]<$v['Taille']){
			$MainOutput->AddTexte(" - ".$v['Message']);
			$MainOutput->br();
			$Prob = true;
		}
		
	}
	if($INFO['NotesAffichage']<>""){
			$MainOutput->AddTexte(" - ".$INFO['NotesAffichage']);
			$MainOutput->br();	
	}
	if(!$Prob){
			$MainOutput->AddTexte(" - Votre piscine répond à toutes les exigences concernant de l'affichage");
			$MainOutput->br();
	}
	
	
	
	
	$MainOutput->br();
	$MainOutput->AddTexte('Construction','Titre');
	$MainOutput->br(2);
	$Prob = false;
	foreach($ConstructionTrack as $k => $v){
		if(!$INFO[$k]){
		$MainOutput->AddTexte(" - ".$v);
		$MainOutput->br();
		$Prob = true;
		}
	}
	if(!$Prob){
		$MainOutput->AddTexte(" - Votre piscine répond à toutes les exigences concernant de la construction");
		$MainOutput->br();
	}
	
	if($INFO['NotesConstruction']<>""){
			$MainOutput->AddTexte(" - ".$INFO['NotesConstruction']);
			$MainOutput->br();	
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