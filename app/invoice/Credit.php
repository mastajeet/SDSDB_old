<?php
include_once('invoice.php');

class Credit extends Invoice{

    function __construct($Args){
        parent::__construct($Args);
        $this->Credit = true;
        $this->updated_values[] = "Credit";
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

    function get_customer_transaction()
    {
        $balance = $this->get_balance();
        $detail = "Crédit ".$this->Cote."-".$this->Sequence;
        return array("date"=>new DateTime("@".$this->EnDate),
            "notes"=>$detail,
            "debit"=>$balance['total'],
            "credit"=>0);
    }

    function get_items()
    {
        return countableInvoiceItem::find_item_by_invoice_id($this->IDFacture);
    }

}
