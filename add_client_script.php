<?PHP
$SQL = new SQLclass();
if(!isset($_POST['FORMPiece'])){
	$_POST['FORMPiece']=0;
}
if(!isset($_POST['FORMActif'])){
	$_POST['FORMActif']=0;
}
if(!isset($_POST['FORMDepotPaye'])){
	$_POST['FORMDepotPaye']=0;
}


// VÉRIFIER SI UN AUTRE CLIENT A LE MEME NOM OU LA MEME COTE
$Req = "SELECT IDClient FROM client WHERE Nom='".$_POST['FORMNom']."' || `Cote`='".$_POST['FORMCote']."'";
$SQL->SELECT($Req);
if($Rep= $SQL->FetchArray()){
	$MainOutput->addtexte("Un client du même nom ou avec une cote identique existe déjà	[<a OnClick=history.back();><u>Retour</u></a>]
	",'Warning');
	$_GET['Section'] = "Display_Client";
	
$_POST['FORMIDClient'] = $Rep['IDClient'];
}else{


$Req = "INSERT INTO client(`Nom`,`Cote`,`Tel`,`Adresse`,`Fax`,`Facturation`,`FrequenceFacturation`,`TXH`,`Notes`,`Ferie`,`Email`,`RespP`,`RespF`,`Actif`,`Piece`,`Depot`,`DepotP`) VALUES
(
'".addslashes($_POST['FORMNom'])."',
'".$_POST['FORMCote']."',
'".$_POST['FORMTel1'].$_POST['FORMTel2'].$_POST['FORMTel3']."',
'".addslashes($_POST['FORMAdresse'])."',
'".$_POST['FORMFax1'].$_POST['FORMFax2'].$_POST['FORMFax3']."',
'".$_POST['FORMFacturation']."',
'".$_POST['FORMFrequenceFacturation']."',
'".$_POST['FORMTXH']."',
'".addslashes($_POST['FORMTXH'])."',
'".$_POST['FORMFerie']."',
'".$_POST['FORMEmail']."',
'".$_POST['FORMRespP']."',
'".$_POST['FORMRespF']."',
'".$_POST['FORMActif']."',
'".$_POST['FORMPiece']."',
'".$_POST['FORMDepot']."',
'".$_POST['FORMDepotPaye']."')";
	$SQL->insert($Req);
$_GET['IDClient']= get_last_id('client');
$_GET['Section'] = "Display_Client";
}



?>
