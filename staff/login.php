<?PHP

$Date = getdate(time());
$DateStr = $Date['mday']."-".$Date['mon']."-".$Date['year'];
$IP = $_SERVER['REMOTE_ADDR'];

$Req = "SELECT Count(IDLogin) as NBTentatives FROM login WHERE IP ='".$IP."' AND Time='".$DateStr."' GROUP BY IP and Time";
$SQL->SELECT($Req);
$Rep = $SQL->FetchArray();
if($Rep['NBTentatives']>3){

	include('locked.php'); 

}else{
	
	include('welcome.php');
    if(isset($_GET['oldapp'])){
        $MainOutput->AddOutput($WarningOutput->Send(1), 0, 0);
        $MainOutput->addform('Connexion au logiciel de gestion');
        $MainOutput->inputhidden_env('Action', 'Login');

        $MainOutput->inputselect('CIESDS', array('QC' => 'Service de sauveteurs: Qu�bec', 'TR' => 'Service de sauveteurs: Trois-Rivi�res', 'MTL' => 'Service de sauveteurs: Montr�al'), 'QC', 'Compagnie');
        $MainOutput->inputtext('IDEmploye', 'Num�ro&nbsp;d\'employ�', '3');
        $MainOutput->inputtext('NAS', '3 dernier&nbsp;NAS', '3');

        $MainOutput->formsubmit('Login');
    }
}

echo $MainOutput->send(1);

?>