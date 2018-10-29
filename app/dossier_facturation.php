<?php

class DossierFacturation
{

    const ID_PAYMENT = "IDPaiement";
    const ID_FACTURE = "IDFacture";

    function __construct($cote, $year){
        $this->cote = $cote;
        $this->year = $year;
        $this->sql_connection = new SqlClass();
    }

    function get_all_factures(){
        $requete_all_facture_for_year = $this->generate_get_all_facture_query();
        $this->sql_connection->Select($requete_all_facture_for_year);
        $factures = [];
        while($facture_id_cursor = $this->sql_connection->FetchArray()){
            $id_facture  = $facture_id_cursor[self::ID_FACTURE];
            $factures[] = new Facture($id_facture);
        }

        return $factures;
    }

    private function generate_get_all_facture_query()
    {
        $first_day_of_year = mktime(0, 0, 0, 1, 1, $this->year);
        $first_day_of_next_year = mktime(0, 0, 0, 1, 1, $this->year + 1);
        $requete_all_facture_for_year = "SELECT IDFacture from facture WHERE Cote='".$this->cote."' AND semaine>=" . $first_day_of_year . " AND semaine<" . $first_day_of_next_year." ORDER BY EnDate DESC";

        return $requete_all_facture_for_year;
    }

    function get_all_payments(){
        $requete_all_payment_for_year = $this->generate_get_all_payment_query();
        $this->sql_connection->Select($requete_all_payment_for_year);
        $payments = [];
        while($payment_id_cursor = $this->sql_connection->FetchArray()){
            $id_facture  = $payment_id_cursor[self::ID_PAYMENT];
            $payments[] = new Payment($id_facture);
        }

        return $payments;
    }

    private function generate_get_all_payment_query(){
        $first_day_of_year = mktime(0, 0, 0, 1, 1, $this->year);
        $first_day_of_next_year = mktime(0, 0, 0, 1, 1, $this->year + 1);
        $requete_all_payment_for_year = "SELECT IDPaiement from paiement WHERE Cote='".$this->cote."' AND Date>=" . $first_day_of_year . " AND Date<" . $first_day_of_next_year." ORDER BY Date DESC";

        return $requete_all_payment_for_year;
    }

    function get_total_billed(){
        $factures = $this->get_all_factures();
        $total_billed = Array("sub_total"=>0, "tps"=>0, "tvq"=>0, "total"=>0);

        foreach($factures as $IDFacture => $facture){
            if(!$facture->is_credit()){
                $facture_balance = $facture->get_balance();

                $total_billed["sub_total"] += $facture_balance["sub_total"];
                $total_billed["tps"] += $facture_balance["tps"];
                $total_billed["tvq"] += $facture_balance["tvq"];
                $total_billed["total"] += $facture_balance["total"];
            }
        }

        return $total_billed;
    }


}