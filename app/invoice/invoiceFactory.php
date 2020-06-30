<?php
include_once('app/invoice/Credit.php');
include_once('app/invoice/shiftInvoice.php');
include_once('app/invoice/equipmentInvoice.php');
include_once('app/invoice/avanceClient.php');

class InvoiceFactory{

    static function getTypedInvoice($invoice){
        $sub_type = null;

        if($invoice->is_credit()){
            $sub_type = Credit::class;
        }elseif($invoice->is_materiel()){
            $sub_type = EquipmentInvoice::class;
        }elseif($invoice->is_avance_client()){
            $sub_type = AvanceClient::class;
        }elseif($invoice->is_interest()){
            $sub_type = InterestInvoice::class;
        }else{
            $sub_type = ShiftInvoice::class;
        }

        return new $sub_type($invoice->IDFacture);
    }
}