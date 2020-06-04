<?php

include_once('./app/dossier_facturation/dossierFacturation.php');
include_once('./app/facture/facture.php');
include_once('./app/payment/payment.php');

class TestDossierFacturation extends PHPUnit_Framework_TestCase
{
    const UN_DOSSIER_FACTURATION = "TDF";
    const UNE_ANNEE_DE_FACTURATION = "2018";
    const UNE_ANNEE_DE_FACTURATION_AVEC_SOLDE_NEGATIF = "2017";
    const UNE_ANNEE_DE_FACTURATION_AVEC_ACTION_SUR_PLUSIEURS_MOIS = "2020";
    const UN_MOIS_AVEC_DES_FACTURES = 3;
    const A_NUMBER_OF_SHOWN_TRANSACTIONS = "5";
    const A_TOLERANCE = 0.10;
    private $dossier_facturation;
    private $transaction_list;
    /**
     * @before
     */
    function setup(){
        $this->dossier_facturation = new DossierFacturation($this::UN_DOSSIER_FACTURATION, $this::UNE_ANNEE_DE_FACTURATION);
        $this->transaction_list = $this->dossier_facturation->get_transaction();
    }

    function test_givenCorrectCoteAndYear_whenGetAllTimeFactures_thenGetAllFactureForCoteAndYear(){
        $factures = $this->dossier_facturation->get_all_factures();

        $this->assertEquals(13, count($factures));
    }

    function test_givenCorrectCoteAndYear_whenGetAllPayments_thenGetAllPayments(){
        $payments = $this->dossier_facturation->get_all_payments();

        $this->assertEquals(4, count($payments));
    }

    function test_whenGetTotalBilled_thenSumAllFactureWithRespectiveTaxes(){
        $total_billed = $this->dossier_facturation->get_total_billed();

        $this->assertEquals(2210, $total_billed["sub_total"],'',0.001);
        $this->assertEquals(110.50, $total_billed["tps"],'',0.001);
        $this->assertEquals(220.48, $total_billed["tvq"],'',0.001);
        $this->assertEquals(2540.98, $total_billed["total"],'',0.001);
    }

    function test_whenGetTotalCredited_thenSumAllCreditWithRespectiveTaxes(){
        $total_billed = $this->dossier_facturation->get_total_credited();

        $this->assertEquals(-800, $total_billed["sub_total"],'',0.001);
        $this->assertEquals(-40, $total_billed["tps"],'',0.001);
        $this->assertEquals(-79.8, $total_billed["tvq"],'',0.001);
        $this->assertEquals(-919.8, $total_billed["total"],'',0.001);
    }

    function test_whenGetTotalToBePaid_thenSumFacutureAndCredit(){
        $total_to_be_paid = $this->dossier_facturation->get_total_to_be_paid();

        $this->assertEquals(1410, $total_to_be_paid["sub_total"],'',0.001);
        $this->assertEquals(70.5, $total_to_be_paid["tps"],'',0.001);
        $this->assertEquals(140.68, $total_to_be_paid["tvq"],'',0.001);
        $this->assertEquals(1621.18, $total_to_be_paid["total"],'',0.001);
    }

    function test_whenGetTotalPaid_thenSumAllPaymentsForCurrenyYear(){
        $total_paid = $this->dossier_facturation->get_total_paid();

        $this->assertEquals(859.89, $total_paid,'',0.001);
    }

    function test_whenGetBalanceDetails_thenTotalToPayTotalPaidAndDifference(){
        $balance_to_pay = $this->dossier_facturation->get_balance_details();

        $this->assertEquals(1621.18, $balance_to_pay["total_to_pay"],'',0.001);
        $this->assertEquals(859.89, $balance_to_pay["total_paid"],'',0.001);
        $this->assertEquals(761.29, $balance_to_pay["balance"],'',0.001);
    }

    function test_whenGetAvanceClientBalance_thenGetSumOfUnusedAvanceClient(){
        $avance_client = $this->dossier_facturation->get_avance_client_balance();

        $this->assertEquals(200, $avance_client, 0.001);
    }

    function test_whenGetTransactions_thenGetCorrectAmountOfTransaction(){
        $this->assertEquals(15, count($this->transaction_list));
    }

    function test_whenGetTransactions_thenGetTransactionInCorrectOrder(){
        $old_value = new DateTime("@0");
        foreach($this->transaction_list as $transaction){
            $this->assertGreaterThanOrEqual($old_value, $transaction['date']);
            $old_value = $transaction['date'];
        }
    }

    function test_whenGetLastTransactions_thenGetLastNTransactionsAndAnteriorBalance(){
        $last_transactions = $this->dossier_facturation->get_last_transactions(self::A_NUMBER_OF_SHOWN_TRANSACTIONS);

        $this->assertEquals(1766.1,$last_transactions['opening_balance'],'',0.001);
        $this->assertEquals(self::A_NUMBER_OF_SHOWN_TRANSACTIONS,count($last_transactions['transactions']));
    }

    function test_whenGetTransaction_thenTransactionHaveBalance(){
        $this->assertEquals(761.29, $this->transaction_list[14]['balance'],'',0.001);
    }

    function test_givenDossierFacturationWithOutstandingBalance_whenHasOutstandingBalance_thenReturnTrue(){
        $this->assertTrue($this->dossier_facturation->has_outstanding_balance(self::A_TOLERANCE));
    }

    function test_givenDossierFacturationWithNegativeOutstandingBalance_whenHasOutstandingBalance_thenReturnTrue(){
        $dossier_facturation = new DossierFacturation($this::UN_DOSSIER_FACTURATION, $this::UNE_ANNEE_DE_FACTURATION_AVEC_SOLDE_NEGATIF);

        $this->assertTrue($dossier_facturation->has_outstanding_balance(self::A_TOLERANCE));
    }

    function test_givenDossierFacturationWithFactureWithinAMonth_whenGetMonthlyFacture_thenGetFactureForTheGivenMonth(){
        $dossier_facturation = new DossierFacturation($this::UN_DOSSIER_FACTURATION, $this::UNE_ANNEE_DE_FACTURATION_AVEC_ACTION_SUR_PLUSIEURS_MOIS);
        $factures = $dossier_facturation->get_factures_for_month($this::UN_MOIS_AVEC_DES_FACTURES);
        $sum_factures = $dossier_facturation->sum_all_factures($factures);

        $this->assertEquals(sizeof($factures), 3);
        $this->assertEquals($sum_factures['sub_total'], 600,'',0.001 );
    }

    function test_givenDossierFacturationWithFactureWithinAMonth_whenGetMonthlyPayments_thenGetPaymentsForTheGivenMonth(){
        $dossier_facturation = new DossierFacturation($this::UN_DOSSIER_FACTURATION, $this::UNE_ANNEE_DE_FACTURATION_AVEC_ACTION_SUR_PLUSIEURS_MOIS);
        $payments = $dossier_facturation->get_payments_for_month($this::UN_MOIS_AVEC_DES_FACTURES);
        $sum_payments = $dossier_facturation->sum_all_payments($payments);


        $this->assertEquals(sizeof($payments), 1);
        $this->assertEquals($sum_payments, 200,'',0.001 );
    }

    function test_givenYear_whenFindByYear_thenGetAllDossierForAllCotesThatHaveFactureOrPayments(){
        $dossiers_facturation = DossierFacturation::find_all_dossiers_facturation_by_year($this::UNE_ANNEE_DE_FACTURATION);

        $this->assertEquals(sizeof($dossiers_facturation), 9);
    }

    function test_givenYearWithUnpaidFacture_whenGetUnpaidFacture_thenObtainListofUnpaiddFacture(){
        $dossiers_facturation = new DossierFacturation($this::UN_DOSSIER_FACTURATION, $this::UNE_ANNEE_DE_FACTURATION);
        $unpaid_factures = $dossiers_facturation->get_unpaid_factures();

        $this->assertEquals(sizeof($unpaid_factures), 4);
        $this->assertFalse($unpaid_factures[0]->is_paid());
    }
}
