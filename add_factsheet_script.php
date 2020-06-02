<?PHP
$Info = get_facture_info($_POST['IDFacture']);
if($Info['Credit']){
	$_POST['FORMTXH'] = -$_POST['FORMTXH'];
}

if($_POST['Materiel']){
	if($_POST['FORMNotes']==""){
		$Notes = $_POST['FORMItem'];
	}else{
		$Notes = $_POST['FORMNotes'];
	}
	$_POST['FORMNotes']= $Notes;
	if($_POST['FORMTXH']==0){
		$SQL = new SQLclass;
		$Req = "SELECT Vente FROM item WHERE Description = '".addslashes($_POST['FORMItem'])."'";
		$SQL->SELECT($Req);
		$Rep = $SQL->FetchArray();
		$_POST['FORMTXH'] = $Rep['Vente'];
	}
	$Start = $_POST['FORMStart'];
	$End = $_POST['FORMEnd'];
	$_POST['FORMJour']=0;
}else{
$Start = $_POST['FORMStart']*60*60;
$End = $_POST['FORMEnd']*60*60;
}
$Req = "INSERT INTO factsheet(`IDFacture`,`Start`,`End`,`Jour`,`TXH`,`Notes`) VALUES(".$_POST['IDFacture'].",".$Start.",".$End.",".$_POST['FORMJour'].",".$_POST['FORMTXH'].",'".addslashes($_POST['FORMNotes'])."')";
$SQL = new sqlclass;
$SQL->INSERT($Req);
?>