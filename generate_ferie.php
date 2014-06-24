<?PHP
if(!isset($_GET['FORMTime4'])){
$MainOutput->AddForm('Calculer un férié','index.php','GET');
$MainOutput->inputtime('Time','','Date',array('Time'=>FALSE,'Date'=>TRUE));
$MainOutput->inputhidden_env('ToPrint','TRUE');
$MainOutput->inputhidden_env('Section','Calcul_Ferie');
$MainOutput->formSubmit('Calculer');
}else{
$Date = get_last_sunday(0,mktime(0,0,0,$_GET['FORMTime4'],$_GET['FORMTime5'],$_GET['FORMTime3']));
$SQL = new sqlclass;
$Req = "SELECT IDPaye FROM paye WHERE Semaine1=".$Date." OR Semaine2=".$Date;
$SQL->SELECT($Req);
$Rep = $SQL->FetchArraY();
$EL = get_employe_working($Rep[0]);
$TOTAL =0;

foreach($EL as $k=>$v){
	$EL[$k]['Ajust'] = round(get_employe_ferie($k,$Date),2);	
	$TOTAL = $TOTAL + $EL[$k]['Ajust'];
}

$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol();
	$MainOutput->AddTexte('No','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol();
	$MainOutput->AddTexte('Nom','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol();
	$MainOutput->AddTexte('Prénom','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol();
	$MainOutput->AddTexte('Ajustement','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

foreach($EL as $k=>$v){
$MainOutput->OpenRow();
$MainOutput->OpenCol();
	$MainOutput->AddTexte($k);
$MainOutput->CloseCol();
$MainOutput->OpenCol();
	$MainOutput->AddTexte($v['Nom']);
$MainOutput->CloseCol();
$MainOutput->OpenCol();
	$MainOutput->AddTexte($v['Prenom']);
$MainOutput->CloseCol();
$MainOutput->OpenCol();
	$MainOutput->AddTexte($v['Ajust']);
$MainOutput->CloseCol();
$MainOutput->CloseRow();
}
$MainOutput->OpenRow();
$MainOutput->OpenCol('',3);
$MainOutput->AddTexte('<div align=right>Total :','Titre');
$MainOutput->AddTexte('<div align=right>'.$TOTAL.' $');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->CloseTable();
echo $MainOutput->send(1);
}

echo $MainOutput->send(1);