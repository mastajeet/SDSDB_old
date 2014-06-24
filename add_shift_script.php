<?PHP
if(!isset($_POST['FORMAssistant']))
	$_POST['FORMAssistant']="";
$FROM = mktime(0,0,0,$_POST['FORMFROM4'],$_POST['FORMFROM5'],$_POST['FORMFROM3']);
$TO = mktime(0,0,0,$_POST['FORMTO4'],$_POST['FORMTO5'],$_POST['FORMTO3']);
$TIME = $FROM;
$SQL = new sqlclass;
$SemaineStart = get_last_sunday(0,$TIME);
while($TIME<=$TO){

	$Week = get_last_sunday(0,$TIME);
	   
	$Day = intval(date("w",$TIME));
	
        $Start = 60*($_POST['FORMStart1']+60*$_POST['FORMStart2']);
	$End = 60*($_POST['FORMEnd1']+60*$_POST['FORMEnd2']);
	
	if($_POST['FORMTXH']==0){
			$Req = "
			SELECT client.TXH 
			FROM client JOIN installation on 
			installation.IDClient = client.IDClient WHERE installation.IDInstallation = '".$_POST['FORMIDInstallation']."'";
			$SQL->SELECT($Req);
			$Rep = $SQL->FetchArray();
			$_POST['FORMTXH'] = $Rep['TXH'];
		}
	
	if(isset($_POST['FORMJours'.$Day])){
		$Req = "INSERT INTO shift(`IDInstallation`,`Start`,`End`,`TXH`,`Salaire`,`Jour`,`Semaine`,`Commentaire`,`Assistant`) 
		VALUES('".$_POST['FORMIDInstallation']."','".$Start."','".$End."','".$_POST['FORMTXH']."','".$_POST['FORMSalaire']."','".$Day."','".$Week."','".$_POST['FORMCommentaire']."','".$_POST['FORMAssistant']."')";
             $SQL->query($Req);
	}
	
        $TIME += get_day_length($TIME);
        
}
$_GET['Section'] = "Display_Shift";
$_GET['Semaine'] = $SemaineStart;
?>