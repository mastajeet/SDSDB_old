
<?PHP

//$SQL3 = new sqlclass;
//$Req3 = "SELECT IDEmploye FROM employe WHERE Session = 'E10' ORDER BY Nom ASC, Prenom ASC";
//$SQL3->SELECT($Req3);
//while($Rep3 = $SQL3->FetchArray()){
//$_GET['IDEmploye'] = $Rep3[0];
if(isset($_GET['IDEmploye'])){
	$Info = get_employe_info($_GET['IDEmploye']);
	$SQL = new sqlclass;
	$MainOutput->OpenTable(550);
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',2);
		$MainOutput->AddTexte('Informations personnelles','Titre');
		$MainOutput->br();
		$MainOutput->addtexte('Veuillez vérifier que toutes ces informations sont bonnes et remettez nous la feuille à la fin de la réunion.  De plus, assurez vous que nous avons vos cartes de qualifications ainsi que votre <b><u>BON</u></b> numéro de compte');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
			$MainOutput->AddTexte('&nbsp;');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',2);
		$MainOutput->AddTexte("Numéro d'employé: ".$Info['IDEmploye'],'Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('60%');

$MainOutput->OpenTable('100%');
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('---------- Personnel -------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('10%');
		$MainOutput->AddTexte('Nom','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte($Info['Prenom']." ".$Info['Nom']);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('10%');
		$MainOutput->AddTexte('NAS','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte(substr($Info['NAS'],0,3)." ".substr($Info['NAS'],3,3)." ".substr($Info['NAS'],6,3));
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	if($Info['DateNaissance']<>0)
		$Naissance = get_date($Info['DateNaissance']);
	$Month = get_month_list();
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('10%');
		$MainOutput->AddTexte('Naissance','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	if($Info['DateNaissance']<>0)
		$MainOutput->AddTexte($Naissance['d']." ".$Month[intval($Naissance['m'])]." ".$Naissance['Y']);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('---------- Contact ----------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();


	$MainOutput->OpenRow();
	$MainOutput->OpenCol('10%');
		$MainOutput->AddTexte('Adresse','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte($Info['Adresse']);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	if($Info['IDSecteur']<>""){
		$Req = "SELECT Nom FROM secteur WHERE IDSecteur = ".$Info['IDSecteur'];
		$SQL->SELECT($Req);
		$Rep = $SQL->FetchArray();
	}
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('10%');
		$MainOutput->AddTexte('Secteur','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	if(isset($Rep))
		$MainOutput->AddTexte($Rep[0]);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('10%');
		$MainOutput->AddTexte('Ville','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte($Info['Ville']);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('10%');
		$MainOutput->AddTexte('Code&nbsp;Postal','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte($Info['CodePostal']);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('10%');
		$MainOutput->AddTexte('Tel&nbsp;Principal','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte("(".substr($Info['TelP'],0,3).") ".substr($Info['TelP'],3,3)."-".substr($Info['TelP'],6,10));
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->OpenRow();
		$MainOutput->OpenCol('10%');
		$MainOutput->AddTexte('Autre','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	if(strlen($Info['TelA'])>4)
		$MainOutput->AddTexte("(".substr($Info['TelA'],0,3).") ".substr($Info['TelA'],3,3)."-".substr($Info['TelA'],6,10));
	else
		$MainOutput->AddTexte("(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('10%');
		$MainOutput->AddTexte('Cellulaire','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	if(strlen($Info['Cell'])>4)
		$MainOutput->AddTexte("(".substr($Info['Cell'],0,3).") ".substr($Info['Cell'],3,3)."-".substr($Info['Cell'],6,10));
	else
		$MainOutput->AddTexte("(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('10%');
		$MainOutput->AddTexte('Paget','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
	if(strlen($Info['Paget'])>4)
		$MainOutput->AddTexte("(".substr($Info['Paget'],0,3).") ".substr($Info['Paget'],3,3)."-".substr($Info['Paget'],6,10));
	else
		$MainOutput->AddTexte("(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	$MainOutput->OpenRow();
	$MainOutput->OpenCol('10%');
		$MainOutput->AddTexte('Email','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte($Info['Email']);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
$MainOutput->CloseTable();

$MainOutput->CloseCol();
$MainOutput->OpenCol('80%');

$MainOutput->OpenTable();
$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',2);
		$MainOutput->addtexte('---------- Qualifications -------------','Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',2);

	
		$MainOutput->OpenTable('100%');

		$MainOutput->OpenRow();
		$MainOutput->OpenCol('60%');
			$MainOutput->AddTexte('Sauvetage','Titre');
		$MainOutput->CloseCol();	
		
		$MainOutput->OpenCol('40%');
			$MainOutput->AddTexte('Expiration','Titre');
		$MainOutput->CloseCol();	
		$MainOutput->CloseRow();
		$Qualif = get_qualif_employe($_GET['IDEmploye']);
		$Req = "SELECT IDQualification, Small FROM Qualification WHERE IDQualification in (1,2,3,4) ORDER BY IDQualification ASC";
		$SQL->SELECT($Req);
		while($Rep = $SQL->FetchArray()){
	$CHECKED = "";
	if($Qualif[$Rep[0]]<>0)
		$CHECKED = "CHECKED";

	$MainOutput->OpenRow();
			
		$MainOutput->OpenCol();
			$MainOutput->addoutput('<input type=checkbox '.$CHECKED.'>',0,0);
			$MainOutput->AddTexte($Rep[1]);
		$MainOutput->CloseCol();	
		
		$MainOutput->OpenCol();
if($CHECKED=="")
		$MainOutput->AddTexte('__________');
else{
		$Expiration = get_date($Qualif[$Rep[0]]);
		$MainOutput->AddTexte($Expiration['m']."/".$Expiration['Y']);
	}
		$MainOutput->CloseCol();	
	$MainOutput->CloseRow();
	
		}
		
		
	$MainOutput->OpenRow();
			
		$MainOutput->OpenCol();
			$MainOutput->AddTexte('Moniteur','Titre');
		$MainOutput->CloseCol();	
		
		$MainOutput->OpenCol();
			$MainOutput->AddTexte('Expiration','Titre');
		$MainOutput->CloseCol();	
	$MainOutput->CloseRow();


	

$Req = "SELECT IDQualification, Small FROM Qualification WHERE IDQualification in (5,6,7,8) ORDER BY IDQualification ASC";
		$SQL->SELECT($Req);
		while($Rep = $SQL->FetchArray()){
	$CHECKED = "";
	if($Qualif[$Rep[0]]<>0)
		$CHECKED = "CHECKED";

	$MainOutput->OpenRow();
			
		$MainOutput->OpenCol();
			$MainOutput->addoutput('<input type=checkbox '.$CHECKED.'>',0,0);
			$MainOutput->AddTexte($Rep[1]);
		$MainOutput->CloseCol();	
		
		$MainOutput->OpenCol('');
if($CHECKED=="")
		$MainOutput->AddTexte('__________');
else{
		$Expiration = get_date($Qualif[$Rep[0]]);
		$MainOutput->AddTexte($Expiration['m']."/".$Expiration['Y']);
	}
		$MainOutput->CloseCol();	
	$MainOutput->CloseRow();
	
		}

	$MainOutput->CloseTable();
	
	
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
$MainOutput->CloseTable();
$MainOutput->CloseCol();

$MainOutput->CloseRow();

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->OpenTable();

	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
			$MainOutput->AddTexte('&nbsp;');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('<b>J\'aimerais travailler</b> : <br>');
		$MainOutput->AddTexte('<input type=radio> Temps plein (40h - 30h)<br>');
		$MainOutput->AddTexte('<input type=radio> Temps partiel (20h - 30h)<br>');
		$MainOutput->AddTexte('<input type=radio> Autre (spéficier)');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	

	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
			$MainOutput->AddTexte('&nbsp;');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('<b>Moyen de transport</b> : _____________________');

	$MainOutput->CloseCol();
	$MainOutput->CloseRow();


	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('<b>Personne à contacter en cas d\'urgence</b> : _____________________');
		$MainOutput->AddTexte('<b>Tél.</b> : ___________________');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();


	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
			$MainOutput->AddTexte('&nbsp;');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('<b>Particularités</b> : ____________________________________________________________________');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('___________________________________________________________________________________');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('___________________________________________________________________________________');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

		$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('___________________________________________________________________________________');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
			$MainOutput->AddTexte('&nbsp;');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
		$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('<b>Suggestions pour un été réussi :</b> ____________________________________________________');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('___________________________________________________________________________________');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('___________________________________________________________________________________');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

		$MainOutput->OpenRow();
	$MainOutput->OpenCol();
		$MainOutput->AddTexte('___________________________________________________________________________________');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();

	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol();
			$MainOutput->AddTexte('&nbsp;');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->CloseTable();
	
	$MainOutput->CloseTable();
}

//$MainOutput->br(5);
//}

echo $MainOutput->Send(1);
?>