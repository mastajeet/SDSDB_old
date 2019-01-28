<?php

include_once('./app/dossier_facturation.php');
include_once('./app/facture/facture.php');
include_once('./app/payment/payment.php');

class TestDossierFacturation extends PHPUnit_Framework_TestCase
{

    const UN_DOSSIER_FACTURATION = "TDF";
    const UNE_ANNEE_DE_FACTURATION = "2018";
    var $dossier_facturation;

    /**
     * @before
     */
    function setup(){
        $this->dossier_facturation = new DossierFacturation($this::UN_DOSSIER_FACTURATION, $this::UNE_ANNEE_DE_FACTURATION );
    }

    function test_givenCorrectCoteAndYear_whenGetAllTimeFactures_thenGetAllFactureForCoteAndYear(){
        $factures = $this->dossier_facturation->get_all_factures();

        $this->assertEquals(11, count($factures));
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

}