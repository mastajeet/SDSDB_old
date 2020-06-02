<?PHP


if($_POST['FORMPourcentage']==0){
	if($_POST['FORMRaison']=='Retard')
		$_POST['FORMPourcentage']=.20;
	if($_POST['FORMRaison']=='Absence')
		$_POST['FORMPourcentage']=.50;
	if($_POST['FORMRaison']=='Remplacement dernière minute')
		$_POST['FORMPourcentage']=.20;
	if($_POST['FORMRaison']=='Pas de spécimen de chèque')
		$_POST['FORMPourcentage']=.15;
	if($_POST['FORMRaison']=='Pas donné ses heures')
		$_POST['FORMPourcentage']=.15;
	if($_POST['FORMRaison']=='Pas retourné après la pluie')
		$_POST['FORMPourcentage']=.25;
	if($_POST['FORMRaison']=='Départ injustifié')
		$_POST['FORMPourcentage']=.40;
	if($_POST['FORMRaison']=='Problème à l\'éthique')
		$_POST['FORMPourcentage']=.20;
}

if($_POST['FORMPourcentage']>1)
	$_POST['FORMPourcentage']=$_POST['FORMPourcentage']/100;
	
if(isset($_POST['FORMDetail'])){
	if($_POST['FORMRaison']=='Pas donné ses heures'){
		$ENDS = get_end_dates(0,get_last_sunday(1));
		$_POST['FORMDetail']=$ENDS['Start']." au ".$ENDS['End'];
		}
}
if($_POST['FORMDate5']==0)
	$Date = time();
else
	$Date = mktime(0,0,0,$_POST['FORMDate4'],$_POST['FORMDate5'],$_POST['FORMDate3']);

$SQL = new sqlclass();
$Req = "INSERT INTO bonicrusher(`IDEmploye`,`Raison`,`Description`,`Date`,`Pourcentage`,`Boniyear`) VALUES(".$_POST['FORMIDEmploye'].",'".addslashes($_POST['FORMRaison'])."',
'".addslashes($_POST['FORMDetail'])."',".$Date.",".$_POST['FORMPourcentage'].",".get_vars('Boniyear').")";
$SQL->Insert($Req);
$MainOutput->AddTexte('Crushed!!','Warning');

$_GET['Section'] = "BoniCrush";




?>