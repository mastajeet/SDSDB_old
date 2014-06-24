<?PHP
$SQL = new sqlclass;
if($_POST['FORMStart']==""){
$Req = "DELETE FROM factsheet WHERE IDFactsheet = ".$_POST['IDFactsheet'];
}else{
$Req = "SELECT Credit FROM facture JOIN factsheet on facture.IDFacture = factsheet.IDFacture WHERE IDFactsheet = ".$_POST['IDFactsheet'];
$SQL->SELECT($Req);
$Rep = $SQL->FetchArray();
if($Rep[0])
	$_POST['FORMTXH'] = -abs($_POST['FORMTXH']);
$Start = $_POST['FORMStart']*60*60;
$End = $_POST['FORMEnd']*60*60;
    if($_POST['FORMJour']==" "){
        $Req = "UPDATE factsheet SET `Start` = ".$Start.", `End` = ".$End.", `TXH` = ".$_POST['FORMTXH'].", `Notes`='".$_POST['FORMNotes']."' WHERE IDFactsheet = ".$_POST['IDFactsheet'];
    }else{
        $Req = "UPDATE factsheet SET `Start` = ".$Start.", `End` = ".$End.", `Jour`=".$_POST['FORMJour'].", `TXH` = ".$_POST['FORMTXH'].", `Notes`='".$_POST['FORMNotes']."' WHERE IDFactsheet = ".$_POST['IDFactsheet'];
    }
}

$SQL->QUERY($Req);
?>