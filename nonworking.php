<?PHP
if(!isset($_POST['FORMFROM5'])){
	$MainOutput->AddForm('Vérifier les disponibilités');
	$MainOutput->inputhidden_env('Section','NonWorking');
	$MainOutput->inputhidden_env('ToPrint','TRUE');
	$MainOutput->inputtime('FROM','Commençant','',array('Date'=>TRUE,'Time'=>FALSE));
	$MainOutput->inputtime('TO','Terminant','',array('Date'=>TRUE,'Time'=>FALSE));
	$MainOutput->FormSubmit('Vérifier');
}else{
	$MainOutput->inputhidden_env('Section','NonWorking');
	$FROM = mktime(0,0,0,$_POST['FORMFROM4'],$_POST['FORMFROM5'],$_POST['FORMFROM3']);
	if($_POST['FORMTO5']=="")
		$TO = $FROM;
	else
	$TO = mktime(0,0,0,$_POST['FORMTO4'],$_POST['FORMTO5'],$_POST['FORMTO3']);
	
	$MainOutput->OpenTable();
	$MainOutput->OpenRow();
	$Month = get_month_list('long');
	while($FROM<=$TO){
		$NW = get_non_working($FROM);
		
		$MainOutput->Opencol();
		$Date = get_date($FROM);

			$MainOutput->AddTexte("<div align=center>Personnes ne travaillant pas le ".$Date['d']."-".$Month[intval($Date['m'])]."</div>",'Titre');
		$MainOutput->OpenTable();
		foreach($NW as $k=>$v){
			$MainOutput->OpenRow();
			$MainOutput->OpenCol();
				$MainOutput->AddTexte($k,'Titre');
			$MainOutput->CloseCol();
			$MainOutput->OpenCol();
				$MainOutput->Addtexte($v['Nom']);
			$MainOutput->CloseCol();
			$MainOutput->OpenCol();
				$MainOutput->AddTexte($v['Prenom']);
			$MainOutput->CloseCol();
			$MainOutput->Opencol();
				$MainOutput->AddPhone($v['Telp']);
			$MainOutput->CloseCol();
			$MainOutput->OpenCol();
				$MainOutput->AddPhone($v['Cell']);
			$MainOutput->CloseCol();
			$MainOutput->CloseRow();
		}
		$MainOutput->CloseTable();
		$MainOutput->CloseCol();
		$FROM = $FROM + 60*60*24;
	}
	$MainOutput->CloseRow();
	$MainOutput->CloseTable();
}
echo $MainOutput->Send(1);
?>