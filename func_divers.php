<?PHP

function get_vars($Vars){
	$SQL = new sqlclass;
        
	$Req = "SELECT `Valeur`, `Type` FROM vars WHERE Nom = '".$Vars."'";
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	if($Rep['Valeur']=="")
		return NULL;
	settype($Rep['Valeur'],$Rep['Type']);
        return $Rep['Valeur'];
}

function send_mail($To,$Sujet,$Message,$CONF=FALSE){
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	if($CONF)
		$headers .= 'Bcc: info@servicedesauveteurs.com';
	$Message = wordwrap($Message,70);
	mail($To,$Sujet,$Message,$headers);
}

function get_info($Table,$ID){
	$SQL = new sqlclass;
	$Table =  strtolower($Table);
	$Req = "SELECT * FROM `".$Table."` WHERE ID".ucfirst($Table)." = ".$ID;
	$SQL->Select($Req);
	return $SQL->FetchArray();
}

function StringArrayToString($VarArray,$Separator=","){
    #This will return a "Separated" string made of items in the array
    $RetString = "";
    foreach ($VarArray as $v){
        $RetString .= $RetString .$v. $Separator;
    }
    return substr($RetString,0,-1);

}

?>