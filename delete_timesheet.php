<?PHP
if(!isset($_GET['Confirme'])){
	$MainOutput->Addlink('index.php?Action=Delete_Timesheet&IDPaye='.$_GET['IDPaye'].'&Confirme=1','Confirmer','','Warning');
	$MainOutput->br();
$_GET['Section']="Display_Timesheet";
	$_GET['FORMIDPaye'] = $_GET['IDPaye'];
}else{
$SQL = new sqlclass;
$Req = "DELETE FROM paye WHERE IDPaye = ".$_GET['IDPaye'];
$SQL->QUERY($Req);
$Req = "DELETE FROM timesheet WHERE IDPaye = ".$_GET['IDPaye'];
$SQL->QUERY($Req);
$_GET['Section']="Display_Timesheet";
}
?>

