<?php
include_once ('facture.php');

class FactureShift extends facture {

    function __construct($Args){
        parent::__construct($Args);
        $this->Debit = true;
        $this->updated_values[] = "Debit";
    }

    static function get_last_facture_query($cote){
        $database_information = self::define_table_info();
        $query = "SELECT IDFacture FROM ".$database_information['model_table']." WHERE Cote='".$cote."' and Debit = 1 and Materiel = 0 ORDER BY Sequence DESC LIMIT 0,1";

        return $query;
    }

    static function get_by_cote_and_sequence($cote, $sequence){
        $database_information = self::define_table_info();
        $query = "SELECT IDFacture FROM ".$database_information['model_table']." WHERE Cote='".$cote."' and  Debit = 1 and Materiel = 0 and Sequence= ".$sequence;

        return $query;
    }
}

