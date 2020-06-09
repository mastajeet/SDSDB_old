<?php
include_once('./app/invoice/invoiceFactory.php');

class DossierFacturation
{

    const ID_PAYMENT = "IDPaiement";
    const ID_FACTURE = "IDFacture";
    const COTE = "Cote";
    private $facture_factory;

    function __construct($cote, $year){
        $this->cote = $cote;
        $this->year = $year;
        $this->facture_factory = new InvoiceFactory();
        $this->sql_connection = new SqlClass();
    }

    function get_total_to_be_paid(){
    // Billed and Credited are summed together because credit are store with minus sign in DataBase...
        $total_billed = $this->get_total_billed();
        $total_credited = $this->get_total_credited();
        $total_to_be_paid = Array(
            "sub_total"=> $total_billed["sub_total"] +$total_credited["sub_total"],
            "tps"=> $total_billed["tps"] +$total_credited["tps"],
            "tvq"=> $total_billed["tvq"] +$total_credited["tvq"],
            "total"=> $total_billed["total"] +$total_credited["total"]
        );

        return $total_to_be_paid;
    }

    static function find_all_dossiers_facturation_by_year($year){
        $first_day_of_year = mktime(0, 0, 0, 1, 1, $year);
        $first_day_of_next_year = mktime(0, 0, 0, 1, 1, $year + 1);
        $dossiers_facturation = array();

        $requete_all_dossiers_facturation = "SELECT DISTINCT Cote from facture WHERE EnDate>=" . $first_day_of_year . " AND EnDate<" . $first_day_of_next_year." ORDER BY Cote ASC";

        $sql_connection = new SqlClass();
        $sql_connection->Select($requete_all_dossiers_facturation);

        while($cote_cursor = $sql_connection->FetchArray()){
            $cote  = $cote_cursor[self::COTE];
            $dossiers_facturation[$cote] = new DossierFacturation($cote, $year);
        }
        return $dossiers_facturation;


    }

    function get_total_billed(){
        $factures = $this->get_all_factures();
        $factures_to_sum = array();
        foreach($factures as $IDFacture => $facture){
            if($facture->is_debit()){
                $factures_to_sum[] = $facture;
            }
        }

        return $this->sum_all_factures($factures_to_sum);
    }

    function has_outstanding_balance($tolerance){
        $balance = $this->get_balance_details();
        return abs($balance['balance'])>$tolerance;
    }

    function get_balance_details(){
        $total_to_pay = $this->get_total_to_be_paid();
        $total_paid = $this->get_total_paid();

        $balance_details = array(
            "total_to_pay"=>$total_to_pay["total"],
            "total_paid"=>$total_paid,
            "balance"=>$total_to_pay["total"] - $total_paid
        );

        return $balance_details;
    }

    function get_avance_client_balance(){
        $factures = $this->get_all_factures();
        $factures_to_sum = array();
        foreach($factures as $IDFacture => $facture){
            if($facture->is_avance_client() && !$facture->is_utilise()){
                $factures_to_sum[] = $facture;
            }
        }
        return $this->sum_all_factures($factures_to_sum)["total"];
    }

    function sum_all_payments($payments){
        $total_paid = 0;
        foreach ($payments as $id_payment => $payment){
            $total_paid += $payment->Montant;

        }
        return $total_paid;
    }

    function get_total_paid(){
        $payments = $this->get_all_payments();
        $total_paid = $this->sum_all_payments($payments);
        return $total_paid;
    }

    function get_total_credited(){
        $factures = $this->get_all_factures();
        $factures_to_sum = array();
        foreach($factures as $IDFacture => $facture){
            if($facture->is_credit()){
                $factures_to_sum[] = $facture;
            }
        }

        return $this->sum_all_factures($factures_to_sum);
    }

    function sum_all_factures($factures){
        $summed_factures = Array("sub_total"=>0, "tps"=>0, "tvq"=>0, "total"=>0);
        foreach($factures as $IDFacture => $facture) {
            $facture_balance = $facture->get_balance();

            $summed_factures["sub_total"] += $facture_balance["sub_total"];
            $summed_factures["tps"] += $facture_balance["tps"];
            $summed_factures["tvq"] += $facture_balance["tvq"];
            $summed_factures["total"] += $facture_balance["total"];
        }

        return $summed_factures;
    }

    function get_factures_for_month($month){
        $first_day_of_month = mktime(0, 0, 0, $month, 1, $this->year);
        $last_day_of_month = mktime(0, 0, 0, $month+1, 1, $this->year);

        $requete_all_facture_for_month = "SELECT IDFacture from facture WHERE Cote='".$this->cote."' AND EnDate>=" . $first_day_of_month . " AND EnDate<" . $last_day_of_month." ORDER BY EnDate ASC";

        $this->sql_connection->Select($requete_all_facture_for_month);
        $factures = [];
        while($facture_id_cursor = $this->sql_connection->FetchArray()){
            $id_facture  = $facture_id_cursor[self::ID_FACTURE];
            $factures[$id_facture] = $this->facture_factory->create_typed_facture(new Invoice($id_facture));
        }
        return $factures;
    }

    function get_payments_for_month($month){
        $first_day_of_month = mktime(0, 0, 0, $month, 1, $this->year);
        $last_day_of_month = mktime(0, 0, 0, $month+1, 1, $this->year);
        $requete_all_facture_for_month = "SELECT IDPaiement from paiement WHERE Cote='".$this->cote."' AND Date>=" . $first_day_of_month . " AND Date<" . $last_day_of_month." ORDER BY Date ASC";
        $this->sql_connection->Select($requete_all_facture_for_month);
        $payments = [];
        while($payment_id_cursor = $this->sql_connection->FetchArray()){
            $id_payment  = $payment_id_cursor[self::ID_PAYMENT];
            $payments[$id_payment] = new Payment($id_payment);
        }
        return $payments;
    }


    function get_all_factures(){
        $requete_all_facture_for_year = $this->generate_get_all_facture_query();
        $this->sql_connection->Select($requete_all_facture_for_year);
        $factures = [];
        while($facture_id_cursor = $this->sql_connection->FetchArray()){
            $id_facture  = $facture_id_cursor[self::ID_FACTURE];
            $factures[$id_facture] = $this->facture_factory->create_typed_facture(new Invoice($id_facture));
        }

        return $factures;
    }

    function get_unpaid_factures(){
        $all_factures = $this->get_all_factures();
        $unpaid_facture = [];
        foreach($all_factures as $facture){
            if(!$facture->is_paid() and ($facture->is_shift() or $facture->is_materiel())){
                $unpaid_facture[] = $facture;
            }
        }

        return $unpaid_facture;
    }

    private function generate_get_all_facture_query(){
        $first_day_of_year = mktime(0, 0, 0, 1, 1, $this->year);
        $first_day_of_next_year = mktime(0, 0, 0, 1, 1, $this->year + 1);
        $requete_all_facture_for_year = "SELECT IDFacture from facture WHERE Cote='".$this->cote."' AND semaine>=" . $first_day_of_year . " AND semaine<" . $first_day_of_next_year." ORDER BY Sequence DESC";

        return $requete_all_facture_for_year;
    }

    function get_all_payments(){
        $requete_all_payment_for_year = $this->generate_get_all_payment_query();
        $this->sql_connection->Select($requete_all_payment_for_year);
        $payments = [];
        while($payment_id_cursor = $this->sql_connection->FetchArray()){
            $id_payment  = $payment_id_cursor[self::ID_PAYMENT];
            $payments[$id_payment] = new Payment($id_payment);
        }

        return $payments;
    }

    private function generate_get_all_payment_query(){
        $requete_all_payment_for_year = "SELECT IDPaiement from paiement WHERE Cote='".$this->cote."' AND PayableYear=" . $this->year." ORDER BY Date DESC";

        return $requete_all_payment_for_year;
    }

    function get_transaction(){
        $payments = $this->get_all_payments();
        $factures = $this->get_all_factures();
        $transactions = array();
        foreach($factures as $facture){
            if(!$facture->is_avance_client()){
                $transactions[] = $facture->get_customer_transaction();
            }
        }
        foreach($payments as $payment){
            $transactions[] = $payment->get_customer_transaction();
        }
        usort($transactions, 'transaction_comparator');
        $this->add_balance_after_transaction($transactions);

        return $transactions;
    }

    private function add_balance_after_transaction(&$transaction_list){
        $current_balance = 0;
        foreach($transaction_list as &$transaction) {
            $current_balance = $current_balance + $transaction['debit'] - $transaction['credit'];
            $transaction['balance'] = $current_balance;
        }
    }

    function get_last_transactions($number_transaction_shown=15){
        $transactions = $this->get_transaction();
        $total_number_of_transaction = count($transactions);
        $number_transaction_to_hide = max(0, $total_number_of_transaction-$number_transaction_shown);
        $last_transactions = array();
        $anterior_balance = 0;
        for($transaction_index=0;$transaction_index<$total_number_of_transaction;$transaction_index++){
            $transaction = $transactions[$transaction_index];
            if($transaction_index < $number_transaction_to_hide){
                $anterior_balance += $transaction['debit']-$transaction['credit'];
            }else{
                $last_transactions[] = $transaction;
            }
        }

        return ["opening_balance"=>$anterior_balance, "transactions"=>$last_transactions];
    }
}

