<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function getnbconnections() {
    $SQL =  new sqlclass();

    $Req = "DELETE FROM presence WHERE Timeout<".time();
    $SQL->Query($Req);

    $Req = "SELECT IDPresence FROM presence WHERE IP='".$_SERVER['REMOTE_ADDR']."'";
    $SQL->Select($Req);
    if($SQL->NumRow()==1){
        return 0;
    }

    $Req = "Select count(IDPresence) FROM presence";

    $SQL->Query($Req);
    $rep = $SQL->FetchArraY();

    return $rep[0];
}

function raisePresence(){
    $SQL = new sqlclass();

    $Req = "SELECT count(IDPresence) FROM presence";
    $SQL->Select($Req);
    $NB = $SQL->NumRow();

    
        $Req = "SELECT IDPresence FROM presence WHERE IP='".$_SERVER['REMOTE_ADDR']."'";
        $SQL->Select($Req);
        $newtime = time() + 5 * 60;
        if($SQL->NumRow()==0){
            if($NB<=10){
                $Req2 = "INSERT Into presence(`IP`,`TimeOut`) VALUES('".$_SERVER['REMOTE_ADDR']."',".$newtime.")";
            }else{
                $Req2 = "";
            }
        }else{
            while($Rep = $SQL->FetchArray()){
                $Req2 = "UPDATE presence SET Timeout=".$newtime." WHERE IDPresence = ".$Rep['IDPresence'];
            }
        }
        $SQL->Query($Req2);
   
}

?>
