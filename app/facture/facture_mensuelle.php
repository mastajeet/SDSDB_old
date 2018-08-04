<?php
include_once ('facture.php');
include_once ('time_facture.php');


class FactureMensuelle extends Facture implements TimeFacture{

    function __construct($Args, $start_of_billable_time)
    {
        parent::__construct($Args);
        $this->start_of_billable_time = $start_of_billable_time;
    }

    static function define_data_types(){

        $data_type = parent::define_data_types();
        $data_type['start_of_billable_time'] = 'ignore';
        return $data_type;
    }

    function get_billable_shift($installation){
        die("okay a implementer pls mensuelle");
        // TODO: Implement get_billable_shift() method.
    }
}