<?php
include_once('invoice.php');

class AvanceClient extends Invoice{

    function __construct($Args){
        parent::__construct($Args);
        $this->AvanceClient = true;
        $this->updated_values[] = "AvanceClient";
    }

    static function get_last_facture_query($cote){
        $database_information = self::define_table_info();
        $query = "SELECT IDFacture FROM ".$database_information['model_table']." WHERE Cote='".$cote."' and AvanceClient = 1 ORDER BY Sequence DESC LIMIT 0,1";

        return $query;
    }

    static function get_by_cote_and_sequence($cote, $sequence){
        $database_information = self::define_table_info();
        $query = "SELECT IDFacture FROM ".$database_information['model_table']." WHERE Cote='".$cote."' and AvanceClient = 1 and Sequence= ".$sequence;

        return $query;
    }
}
