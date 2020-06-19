<?php
include_once('app/invoice/Credit.php');
include_once('app/invoice/shiftInvoice.php');
include_once('app/invoice/equipmentInvoice.php');
include_once('app/invoice/avanceClient.php');

class InvoiceFactory{

    static function create_typed_invoice($facture){
        $sub_type = null;

        if($facture->is_credit()){
            $sub_type = Credit::class;
        }elseif($facture->is_materiel()){
            $sub_type = EquipmentInvoice::class;
        }elseif($facture->is_avance_client()){
            $sub_type = AvanceClient::class;
        }elseif($facture->is_interest()){
            $sub_type = InterestInvoice::class;
        }else{
            $sub_type = ShiftInvoice::class;
        }

        return new $sub_type($facture->IDFacture);
    }
}