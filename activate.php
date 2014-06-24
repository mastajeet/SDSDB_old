<?PHP
$SQL= new sqlclass;
if(isset($_GET['Activate'])){
	if($_GET['Activate'] == "FALSE")
		$_GET['Activate']=0;
	elseif($_GET['Activate'] == "TRUE")
		$_GET['Activate']=1;
		
	if(isset($_GET['IDClient'])){
		$Req = "UPDATE client SET Actif=".$_GET['Activate']." WHERE IDClient =".$_GET['IDClient'];
		$SQL->QUERY($Req);
		if($_GET['Activate']==0){
			$Req2 = "UPDATE installation set Actif=0, Saison=0 WHERE IDClient=".$_GET['IDClient'];
			$SQL->QUERY($Req2);
		}
	}
	if(isset($_GET['IDInstallation'])){

		if($_GET['Activate']==1){
			$Req = "UPDATE installation SET Actif=1 WHERE IDInstallation =".$_GET['IDInstallation'];
			$SQL->QUERY($Req);
			$Info = get_installation_info($_GET['IDInstallation']);
			$Req = "UPDATE client SET Actif=1 WHERE IDClient =".$Info['IDClient'];
			$SQL->QUERY($Req);
		}else{
			$Req = "UPDATE installation SET Actif=0, Saison=0 WHERE IDInstallation =".$_GET['IDInstallation'];
			$SQL->QUERY($Req);
		}
	}
}
if(isset($_GET['Saison'])){
	if($_GET['Saison'] == "FALSE")
		$_GET['Saison']=0;
	elseif($_GET['Saison'] == "TRUE")
		$_GET['Saison']=1;
	

	if($_GET['Saison']==1){
		$Req = "UPDATE installation SET Actif=".$_GET['Saison'].", Saison=".$_GET['Saison']." WHERE IDInstallation =".$_GET['IDInstallation'];
		$SQL->QUERY($Req);
		$Info = get_installation_info($_GET['IDInstallation']);
		$Req = "UPDATE client SET Actif=".$_GET['Saison']." WHERE IDClient =".$Info['IDClient'];
		$SQL->QUERY($Req);
	}else{
	$Req = "UPDATE installation SET Saison=0 WHERE IDInstallation =".$_GET['IDInstallation'];
	$SQL->QUERY($Req);
	}
	

}?>
<script language=JAVASCRIPT>
history.back(2);
</script>