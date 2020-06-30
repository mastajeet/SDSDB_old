<?php
include_once('invoice.php');

class InterestInvoice extends Invoice{

//    private $date_debut_calcul;

    function __construct($Args){
        parent::__construct($Args);
        $this->Debit = true;
        $this->Materiel = true;
        $this->TVQ = 0;
        $this->TPS = 0;
        $this->updated_values[] = "Debit";
        $this->updated_values[] = "Interest";
        $this->updated_values[] = "TVQ";
        $this->updated_values[] = "TPS";
    }

    static function get_last_facture_query($cote){
        $database_information = self::define_table_info();
        $query = "SELECT IDFacture FROM ".$database_information['model_table']." WHERE Cote='".$cote."' and Interest = 1 ORDER BY Sequence DESC LIMIT 0,1";

        return $query;
    }

    static function get_by_cote_and_sequence($cote, $sequence){
        $database_information = self::define_table_info();
        $query = "SELECT IDFacture FROM ".$database_information['model_table']." WHERE Cote='".$cote."' and Interest = 1 and Sequence= ".$sequence;

        return $query;
    }

    function get_items()
    {
        return CountableInvoiceItem::findItemByInvoiceId($this->IDFacture);
    }

//    function add_items($)
}

