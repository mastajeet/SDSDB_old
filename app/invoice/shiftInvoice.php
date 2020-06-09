<?php
include_once('invoice.php');
include_once('app/invoice/invoice_item/timedInvoiceItem.php');


class ShiftInvoice extends Invoice {

    function __construct($Args){
        parent::__construct($Args);
        $this->Debit = true;
        $this->updated_values[] = "Debit";

    }

    function is_shift(){
        return true;
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

    function get_items(){
        return TimedInvoiceItem::find_item_by_invoice_id($this->IDFacture);
    }
}
