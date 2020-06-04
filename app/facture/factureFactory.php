<?php
include_once('app/facture/Credit.php');
include_once('app/facture/factureShift.php');
include_once('app/facture/factureMateriel.php');
include_once('app/facture/avanceClient.php');

class FactureFactory{

    function create_typed_facture($facture){
        $sub_type = null;

        if($facture->is_credit()){
            $sub_type = Credit::class;
        }elseif($facture->is_materiel()){
            $sub_type = FactureMateriel::class;
        }elseif($facture->is_avance_client()){
            $sub_type = AvanceClient::class;
        }elseif($facture->is_interest()){
            $sub_type = FactureInterest::class;
        }else{
            $sub_type = FactureShift::class;
        }

        return new $sub_type($facture->IDFacture);
    }
}