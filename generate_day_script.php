<?PHP
$SQL = new SQLclass;
for($d=0;$d<=6;$d++){

	if(isset($_POST['FORMJours'.$d])){
		if(!isset($_POST['FORMAssistant']))
			$_POST['FORMAssistant']=0;
		$Req = "DELETE FROM horshift WHERE `IDHoraire` = '".$_POST['IDHoraire']."' && `Jour` =".$d." && Assistant=".$_POST['FORMAssistant'];
		$SQL->Query($Req);
		for($s=1;$s<=3;$s++){
			$Start = 60*($_POST['FORMStart'.$s.'1']+60*$_POST['FORMStart'.$s.'2']);
			$End = 60*($_POST['FORMEnd'.$s.'1']+60*$_POST['FORMEnd'.$s.'2']);
			if($Start<>0 && $End<>0 && $End>$Start){
			
				$Req = "INSERT INTO horshift(`Jour`,`Start`,`End`,`Assistant`,`Commentaire`,`TXH`,`Salaire`,`IDHoraire`) VALUES(
				'".$d."',
				'".$Start."',
				'".$End."',	
				'".$_POST['FORMAssistant']."',
				'".addslashes($_POST['FORMCommentaire'])."',
				'".$_POST['FORMTXH']."',
				'".$_POST['FORMSalaire']."',
				'".$_POST['IDHoraire']."')";
				$SQL->Query($Req);
			}
		}
	}
}
?>