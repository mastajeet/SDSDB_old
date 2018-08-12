<?php

include_once ('facture.php');
include_once ('time_facture.php');

class FactureHebdomadaire extends Facture implements TimeFacture{
    function get_billable_shift($installation){
        $sql = new SqlClass();
        $query = "SELECT IDShift from shift WHERE IDInstallation = ".$installation->IDInstallation." and Semaine=".$this->Semaine." ORDER BY Jour ASC, Start ASC";

        $billable_shift = array();

        $sql->Select($query);
        while($shift_record = $sql->FetchAssoc()){
            $billable_shift[] = new Shift($shift_record['IDShift'], new TimeService());
        }

        return $billable_shift;
    }
}
