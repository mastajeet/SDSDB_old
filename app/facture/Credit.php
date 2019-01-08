<?php
include_once ('facture.php');

class Credit extends Facture{

    function __construct($Args){
        parent::__construct($Args);
        $this->Credit = true;
    }

    static function get_last_facture_query($cote){
        $database_information = self::define_table_info();
        $query = "SELECT IDFacture FROM ".$database_information['model_table']." WHERE Cote='".$cote."' and Credit = 1 ORDER BY Sequence DESC LIMIT 0,1";

        return $query;
    }

    static function get_by_cote_and_sequence($cote, $sequence){
        $database_information = self::define_table_info();
        $query = "SELECT IDFacture FROM ".$database_information['model_table']." WHERE Cote='".$cote."' and Credit = 1 and Sequence= ".$sequence;

        return $query;
    }
}
