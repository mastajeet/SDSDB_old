<?php

class paymentService{

    private $facture_service;

    function __construct($facture_service){
        $this->facture_service = $facture_service;
    }

    function delete_payment($payment){
        $paid_facture = $payment->get_paid_facture();
        foreach($paid_facture as $facture){
            $facture->mark_unpaid();
            $facture->save();
        }

        $payment->destroy();
    }

    function add_payment($payment){
        $paid_factures = $payment->get_paid_facture();
        foreach($paid_factures as $facture){
            $facture->mark_paid();
            $facture->save();
        }

        $payment->save();
    }

    function get_payments($payment_dto){
        $cote = $payment_dto['Cote'];
        $date = $payment_dto['Date'];

        $sql = New SqlClass();
        $payment_db_info = Payment::define_table_info();
        $payement_query = "SELECT ".$payment_db_info['model_table_id']." from ".$payment_db_info['model_table']." WHERE Cote = '".$cote."' and Date = ".$date->getTimestamp();
        $sql->Select($payement_query);
        $payments = array();
        while($payment_information = $sql->FetchAssoc()){
            $payment_db_id = $payment_db_info['model_table_id'];
            $payments[$payment_information[$payment_db_id]] =  new Payment($payment_db_id);
        }

        return($payments);
    }
}