<?PHP
$SQL = new SQLclass();
if(!isset($_POST['FORMPiece']))
	$_POST['FORMPiece']=0;
if(!isset($_POST['FORMActif']))
	$_POST['FORMActif']=0;
if(!isset($_POST['FORMDepotPaye']))
	$_POST['FORMDepotPaye']=0;
$Req = "UPDATE client SET

`Nom`='".addslashes($_POST['FORMNom'])."',
`Cote`='".$_POST['FORMCote']."',
`Tel`='".$_POST['FORMTel1'].$_POST['FORMTel2'].$_POST['FORMTel3']."',
`Adresse`='".addslashes($_POST['FORMAdresse'])."',
`Fax`='".$_POST['FORMFax1'].$_POST['FORMFax2'].$_POST['FORMFax3']."',
`Facturation`='".$_POST['FORMFacturation']."',
`FrequenceFacturation`='".$_POST['FORMFrequenceFacturation']."',
`TXH`='".$_POST['FORMTXH']."',
`Notes`='".addslashes($_POST['FORMNotes'])."',
`Ferie`='".$_POST['FORMFerie']."',
`Email`='".$_POST['FORMEmail']."',
`RespP`='".$_POST['FORMRespP']."',
`RespF`='".$_POST['FORMRespF']."',
`Actif`='".$_POST['FORMActif']."',
`Depot`='".$_POST['FORMDepot']."',
`DepotP`='".$_POST['FORMDepotPaye']."',
`Piece`='".$_POST['FORMPiece']."' 
WHERE 
IDClient = '".$_POST['IDClient']."' ";
$SQL->insert($Req);
$_GET['Section'] = "Display_Client";
?>
