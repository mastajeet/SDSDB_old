<?PHP

$SQL = new sqlclass;

if(isset($_GET['IDFactsheet'])){
$Req = "SELECT * FROM factsheet WHERE IDFactsheet = ".$_GET['IDFactsheet'];
$SQL->SELECT($Req);
$Rep = $SQL->FetchArray();
$_GET['IDFacture'] = $Rep['IDFacture'];
$Info = get_facture_info($_GET['IDFacture']);
}else{
$Info = get_facture_info($_GET['IDFacture']);
$Req = "SELECT client.TXH FROM `client` join installation join facture ON facture.Cote = `installation`.Cote AND `installation`.IDClient = client.IDClient WHERE facture.IDFacture = ".$_GET['IDFacture'];
$SQL->SELECT($Req);
$Rep2 = $SQL->FetchArray();
$Rep = array('Start'=>0,'End'=>'0','Notes'=>'','TXH'=>$Rep2['TXH'],'Jour'=>'');
if($Info['Materiel'])
	$Rep['TXH']=0;
	$Rep['End']=1;
}


$Credit = "";
if($Credit)	
	$Credit = "c";
$MainOutput->AddForm('Ajouter / Modifier une entrée dans la facture '.$Credit.$Info['Cote'].'-'.$Info['Sequence']);

$MainOutput->inputhidden_env('IDFacture',$_GET['IDFacture']);
if(isset($_GET['IDFactsheet'])){
	$MainOutput->inputhidden_env('IDFactsheet',$_GET['IDFactsheet']);
	$MainOutput->inputhidden_env('Action','Factsheet');
	$MainOutput->inputhidden_env('Update',TRUE);
}else{
	$MainOutput->inputhidden_env('Action','Factsheet');
	$MainOutput->inputhidden_env('Update',FALSE);
}
	$MainOutput->inputhidden_env('Materiel',$Info['Materiel']);
if(!$Info['Materiel']){
$MainOutput->InputText('Start','Début','1',round($Rep['Start']/3600,2));
$MainOutput->InputText('End','Fin','1',Round($Rep['End']/3600,2));
$MainOutput->InputText('Notes','Notes','32',$Rep['Notes']);
$MainOutput->InputText('TXH','Taux horaire','3',abs($Rep['TXH']));
$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');	
$MainOutput->InputSelect('Jour',$CJour,$Rep['Jour']);
}else{
	$MainOutput->inputhidden_env('FORMStart',0);
	$Req = "SELECT Description,Description FROM item ORDER BY Description ASC";
	$MainOutput->InputSelect('Item',$Req,'Item');
	$MainOutput->InputText('Notes','Item','40',$Rep['Notes']);
	$Req = "SELECT Nom, Nom FROM installation WHERE Cote = '".$Info['Cote']."' ORDER BY Nom ASC";
	$MainOutput->InputSelect('Installation',$Req, 'Installation');
	$MainOutput->InputText('End','Quantité','1',$Rep['End']);
	$MainOutput->InputText('TXH','Prix',5,abs($Rep['TXH']));
}



$MainOutput->formsubmit('Effectuer');
echo $MainOutput->send(1);
?>