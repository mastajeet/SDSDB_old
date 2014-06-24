<?PHP
if(isset($_POST['IDHorshift'])){
	$SQL = new SQLclass();
	$SQL2 = new SQLclass();
	if(!isset($_POST['FORMAssistant']))
		$_POST['FORMAssistant']=0;
	if(!isset($_POST['FORMConfirm']))
		$_POST['FORMConfirm']=0;
	if(!isset($_POST['FORMIDEmploye']))
		$_POST['IDEmploye']=NULL;
	if($_POST['FORMStart2']==0 || $_POST['FORMEnd2']==0){
		$Req = "DELETE FROM horshift WHERE `IDHorshift`='".$_POST['IDHorshift']."'";
	}else{
		
		$Info = get_horshift_info($_POST['IDHorshift']);
		$OldStart = $Info['Start'];
		$OldEnd = $Info['End'];
		$Start = 60*($_POST['FORMStart1']+60*$_POST['FORMStart2']);
		$End = 60*($_POST['FORMEnd1']+60*$_POST['FORMEnd2']);
	
	
		if(isset($_POST['FORMAttach'])){
			// REQUETE QUI V�RIFIE S'IL Y A UN SHIFT QUI FINI TOUT DE SUITE AVANT
			
			$Req = "SELECT IDHorshift FROM horshift WHERE IDHoraire = '".$_POST['IDHoraire']."' && `Jour`='".$_POST['FORMJour']."' && `End`='".$OldStart."' && Assistant='".$_POST['FORMAssistant']."'";
	
			$SQL->SELECT($Req);
			while($Rep = $SQL->FetchArray()){
				$Req2 = "UPDATE Horshift SET `End`= '".$Start."' WHERE `IDHorshift`='".$Rep['IDHorshift']."'";
			$SQL2->UPDATE($Req2);
			}
			
			// REQUETE QUI V�RIFIE S'IL Y A UN SHIFT QUI COMMENCE TOUT DE SUITE APR�S
			
			$Req = "SELECT IDHorshift FROM horshift WHERE IDHoraire = '".$_POST['IDHoraire']."' && `Jour`='".$_POST['FORMJour']."' && `Start`='".$OldEnd."' && Assistant='".$_POST['FORMAssistant']."'";
			$SQL->SELECT($Req);
			while($Rep = $SQL->FetchArray()){
				$Req2 = "UPDATE Horshift SET `Start`= '".$End."' WHERE `IDHorshift`='".$Rep['IDHorshift']."'";
			$SQL2->UPDATE($Req2);
			}
		}
		
		// REQUETE QUI V�RIFIE SI UN SHIFT ENGLOBE UN AUTRE AVANT AU COMPLET 
		
		$Req = "SELECT IDHorshift FROM horshift WHERE IDHoraire = '".$_POST['IDHoraire']."' && `Jour`='".$_POST['FORMJour']."' && `Start`='".$Start."' && Assistant='".$_POST['FORMAssistant']."' && IDHorshift<>'".$_POST['IDHorshift']."'";
		$SQL->SELECT($Req);
		while($Rep = $SQL->FetchArray()){
			$Req2 = "DELETE FROM horshift WHERE `IDHorshift`='".$Rep['IDHorshift']."'";
			$SQL2->QUERY($Req2);
		}
		
		// REQUETE QUI V�RIFIE SI UN SHIFT ENGLOBE UN AUTRE APR�S AU COMPLET
		
		$Req = "SELECT IDHorshift FROM horshift WHERE IDHoraire = '".$_POST['IDHoraire']."' && `Jour`='".$_POST['FORMJour']."' && `End`='".$End."' && Assistant='".$_POST['FORMAssistant']."' && IDHorshift<>'".$_POST['IDHorshift']."'";
		$SQL->SELECT($Req);
		while($Rep = $SQL->FetchArray()){
			$Req2 = "DELETE FROM horshift WHERE `IDHorshift`='".$Rep['IDHorshift']."'";
			
			$SQL2->QUERY($Req2);
		}
		
		
		
		if($_POST['FORMIDEmploye']==" "){
			$Req = "UPDATE horshift SET
			`Start`='".$Start."',
			`End`='".$End."',
			`Jour`='".$_POST['FORMJour']."',
			`Assistant`='".$_POST['FORMAssistant']."',
			`TXH`='".$_POST['FORMTXH']."',
			`Salaire`='".$_POST['FORMSalaire']."',
			`IDEmploye` = '".$_POST['FORMIDEmploye']."',
			`Confirm` = 0,
			`Commentaire`='".addslashes($_POST['FORMCommentaire'])."'
			WHERE `IDHorshift`='".$_POST['IDHorshift']."'";
		}else{
			$Req = "UPDATE horshift SET
			`Start`='".$Start."',
			`End`='".$End."',
			`Jour`='".$_POST['FORMJour']."',
			`Assistant`='".$_POST['FORMAssistant']."',
			`TXH`='".$_POST['FORMTXH']."',
			`Salaire`='".$_POST['FORMSalaire']."',
			`IDEmploye` = '".$_POST['FORMIDEmploye']."',
			`Confirm` = '".$_POST['FORMConfirm']."',
			`Commentaire`='".addslashes($_POST['FORMCommentaire'])."'
			WHERE `IDHorshift`='".$_POST['IDHorshift']."'";
		}
	}
	$SQL->QUERY($Req);
}
?>
<script language=JAVASCRIPT>
history.back(2);
</script>