<?php

Abstract Class InvoiceItem extends baseModel
{

    public $End;
    public $Notes;
    public $Start;
    public $Jour;
    public $IDFacture;
    public $TXH;
    public $IDFactsheet;

    abstract function add_to_balance(&$Balance);
    abstract function getNumberOfBilledItems();
    abstract function getDetails();
    abstract function isEmpty();
    abstract static function fromDetails($invoice_item_dto);
    abstract static function findItemByInvoiceId($invoice_id);

    static function define_table_info(){
        return array("model_table" => "factsheet",
            "model_table_id" => "IDFactsheet");
    }

    static function define_data_types(){
        return array("IDFactsheet"=>'ID',
            'TXH'=>'float');
    }

    static function get_item_by_invoice_id_query($invoice_id){
        $database_information = InvoiceItem::define_table_info();
        $query = "SELECT ".$database_information['model_table_id']." FROM ".$database_information['model_table']." WHERE IDFacture=".$invoice_id;

        return $query;
    }


}
