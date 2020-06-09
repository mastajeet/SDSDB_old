<?php

Abstract Class InvoiceItem extends baseModel
{

    public $End;
    public $Notes;
    public $Start;
    public $Jour;
    public $IDFacture;
    public $IDFactsheet;


    abstract function add_bill_item_to_balance(&$Balance);


    static function define_table_info(){
        return array("model_table" => "factsheet",
            "model_table_id" => "IDFactsheet");
    }

    static function define_data_types(){
        return array("IDFactsheet"=>'ID',
            'TXH'=>'float');
    }

}