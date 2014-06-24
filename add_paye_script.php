<?PHP
$SQL = new sqlclass;
$Finissant = mktime(0,0,0,$_POST['FORMFinissant4'],$_POST['FORMFinissant5'],$_POST['FORMFinissant3']);

$Sem2 = get_last_sunday(0,$Finissant);
$Sem1 = get_last_sunday(1,$Finissant);

$Verif = "SELECT IDPaye FROM paye WHERE `Semaine1`=".$Sem1." OR `Semaine2`=".$Sem1." OR `Semaine1`=".$Sem2." OR `Semaine2`=".$Sem2;
$SQL->SELECT($Verif);
if($SQL->NumRow()<>0){
	$MainOutput->addtexte("Une paye incluant la date de fin existe déjà. [<a OnClick=history.back();><u>Retour</u></a>]
	",'Warning');
	$Rep = $SQL->FetchArray();
	$Section = "Display_Timesheet";
	$_GET['FORMIDPaye'] = $Rep[0];
}else{
$Req = "INSERT INTO paye(`Semaine1`,`Semaine2`,`No`) VALUES('".$Sem1."','".$Sem2."','".$_POST['FORMNo']."')";
$SQL->INSERT($Req);
$IDPaye = get_last_id('paye');
$_GET['ENR'] = TRUE;
$_GET['Semaine'] = $Sem1;
$_GET['Section'] = "TimeSheet";
}
?>