<?PHP

$Req = "SELECT Email FROM employe WHERE `Session` LIKE '".$_GET['Session']."' ";
$SQL->SELECT($Req);
$NBEmail =0;
$EmailStr = "";

while($Rep = $SQL->FetchArray()){

		$EmailStr .= "; " . $Rep['Email'];
		$NBEmail++;
		
		if($NBEmail>=50){
			
			$MainOutput->addtexte($EmailStr);
			$MainOutput->br(2);
			$EmailStr="";
			$NBEmail =0;
		}
		
		
}

echo $MainOutput->send(1);

?>