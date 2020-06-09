<?php
include_once('invoice.php');

class EquipmentInvoice extends Invoice{

    function __construct($Args){
        parent::__construct($Args);
        $this->Debit = true;
        $this->Materiel = true;
        $this->updated_values[] = "Debit";
        $this->updated_values[] = "Materiel";
    }

    static function get_last_facture_query($cote){
        $database_information = self::define_table_info();
        $query = "SELECT IDFacture FROM ".$database_information['model_table']." WHERE Cote='".$cote."' and Materiel = 1 ORDER BY Sequence DESC LIMIT 0,1";

        return $query;
    }

    static function get_by_cote_and_sequence($cote, $sequence){
        $database_information = self::define_table_info();
        $query = "SELECT IDFacture FROM ".$database_information['model_table']." WHERE Cote='".$cote."' and Materiel = 1 and Sequence= ".$sequence;

        return $query;
    }

    function get_items()
    {
        return countableInvoiceItem::find_item_by_invoice_id($this->IDFacture);
    }
}

