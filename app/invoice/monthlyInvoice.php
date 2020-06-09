<?php
include_once('shiftInvoice.php');
include_once('timeFacture.php');


class MonthlyInvoice extends ShiftInvoice implements TimeFacture{

    public $start_of_billable_time;
    public $time_service;

    function __construct($Args, $start_of_billable_time)
    {
        parent::__construct($Args);
        $this->start_of_billable_time = $start_of_billable_time;
        $this->time_service = new TimeService();
    }

    static function define_data_types(){
        $data_type = parent::define_data_types();
        $data_type['start_of_billable_time'] = 'ignore';
        $data_type['time_service'] = 'service';

        return $data_type;
    }

    function get_billable_shift($installation){
        $weeks_of_month = $this->time_service->get_weeks_of_month($this->start_of_billable_time);

        $shift_for_first_week = $this->get_billable_shift_for_first_week($installation, array_slice($weeks_of_month, 0, 1 )[0]);
        $shift_for_middle_weeks = $this->get_billable_shift_for_middle_week($installation, array_slice($weeks_of_month, 1, -1 ));
        $shift_for_last_week = $this->get_billable_shift_for_last_week($installation, array_slice($weeks_of_month, -1 )[0]);

        return array_merge($shift_for_first_week, $shift_for_middle_weeks, $shift_for_last_week);
    }

    private function get_billable_shift_for_first_week($installation, $first_week_datetime){
        try {
            $switch_day = $this->time_service->get_week_day_that_changes_month($first_week_datetime);
        }catch (Exception $exception){
            $switch_day = 0; #Le premier jour etait deja dans le bon mois
        }
        $shift_query = "SELECT IDShift from shift WHERE IDInstallation=".$installation->IDInstallation." and Facture=0 and Semaine=".$first_week_datetime->getTimestamp()." and Jour >= ".$switch_day;
        $shifts_record = $this->select($shift_query);
        $shift_to_bill = array();
        foreach($shifts_record as $shift_record){
            $shift_to_bill[] = new Shift($shift_record['IDShift'], $this->time_service);
        }

        return $shift_to_bill;
    }

    private function get_billable_shift_for_middle_week($installation, $middle_week_datetime_array){

        $week_to_query = "";
        foreach($middle_week_datetime_array as $start_of_week){
            $week_to_query .= ",".$start_of_week->getTimestamp();
        }
        $week_to_query = substr($week_to_query,1);

        $shift_query = "SELECT IDShift from shift WHERE IDInstallation='".$installation->IDInstallation."' and Facture=0 and Semaine in (".$week_to_query.")";
        $shifts_record = $this->select($shift_query);

        $shift_to_bill = array();
        foreach($shifts_record as $shift_record){
            $shift_to_bill[] = new Shift($shift_record['IDShift'], $this->time_service);
        }

        return $shift_to_bill;
    }

    private function get_billable_shift_for_last_week($installation, $last_week_datetime){

        try {
            $switch_day = $this->time_service->get_week_day_that_changes_month($last_week_datetime);
        }catch (Exception $exception){
            $switch_day = 6; #Le dernier jour etait encore dans le bon mois
        }

        $shift_query = "SELECT IDShift from shift WHERE IDInstallation=".$installation->IDInstallation." and Facture=0 and Semaine=".$last_week_datetime->getTimestamp()." and Jour < ".$switch_day;
        $shifts_record = $this->select($shift_query);
        $shift_to_bill = array();
        foreach($shifts_record as $shift_record){
            $shift_to_bill[] = new Shift($shift_record['IDShift'], $this->time_service);
        }

        return $shift_to_bill;
    }
}
