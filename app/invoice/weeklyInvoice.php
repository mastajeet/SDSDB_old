<?php

include_once('shiftInvoice.php');
include_once('timeFacture.php');

class WeeklyInvoice extends ShiftInvoice implements TimeFacture{

    function __construct($Args)
    {
        parent::__construct($Args);
        $this->Weekly = 1;
        $this->updated_values[] = "Weekly";
    }

    function get_billable_shift($installation){
        $sql = new SqlClass();
        $query = "SELECT IDShift from shift WHERE IDInstallation = ".$installation->IDInstallation." and Semaine=".$this->Semaine." ORDER BY Jour ASC, Assistant ASC, Start ASC";

        $billable_shift = array();

        $sql->Select($query);
        while($shift_record = $sql->FetchAssoc()){
            $billable_shift[] = new Shift($shift_record['IDShift'], new TimeService());
        }

        return $billable_shift;
    }

    function getBeginningOfBillablePeriod()
    {
        $beggining_datetime = new DateTime("@".$this->Semaine);

        return $beggining_datetime;
    }
}
