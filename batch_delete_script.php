<?PHP

$SDate = mktime(0,0,0,$_POST['FORMSDate4'],$_POST['FORMSDate5'],$_POST['FORMSDate3']);
$EDate = mktime(0,0,0,$_POST['FORMEDate4'],$_POST['FORMEDate5'],$_POST['FORMEDate3']);
$UpdateStr = "";

$WhereStr="1";
$c=1;
$WhereStr="";
while($c<5){
	$Name = 'C_Box'.$c;
	if(isset($$Name)){
		if($c==2 || $c==3)
			$_POST['FORM'.$$Name] = $_POST['FORMC_Time'.$c.'2']*3600+$_POST['FORMC_Time'.$c.'1']*60;
        if($c==4){
            if(isset($_POST['C_Box4']))
                    $_POST['FORM'.$$Name] = 1;
            else
                $_POST['FORM'.$$Name] = 0;

            $WhereStr .= " AND `".substr($_POST['C_Box'.$c],2)."` = '".addslashes($_POST['FORM'.$$Name])."'";
        }else{
	$WhereStr .= " AND `".substr($_POST['C_Box'.$c],2)."` = '".addslashes($_POST['FORM'.$$Name])."'";
        }
        }
	$c++;
}

batch_delete($SDate,$EDate+86400,$_POST['FORMIDInstallation'],$UpdateStr,$WhereStr);
?>