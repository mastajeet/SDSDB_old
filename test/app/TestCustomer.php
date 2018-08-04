<?php

include_once('app/customer.php');

class TestCustomer extends PHPUnit_Framework_TestCase
{

    private $A_COTE = "ABC";
    private $A_SEMAINE = null;

    /**
     * @before
     */
    function setup_tested_instance(){
        $this->A_SEMAINE = new DateTime();
        $this->A_SEMAINE->setDate(2018,7,31);

        $this->customer_with_facture_hebdomadaire = new Customer(1);
        $this->customer_with_facture_mensuelle = new Customer(17);
    }

    function test_givenCustomerWithFacture_whenCalculateBillsByCote_getSumOfAllBillsByCote(){
//        $bills_by_cote = $this->customer->calculate_facture_by_cote();
    }

    function test_givenCustomerWithFactureMensuelle_whenGenerateFacture_thenFactureAreFactureMensuelle(){
        $facture = $this->customer_with_facture_mensuelle->generate_next_time_facture($this->A_COTE, $this->A_SEMAINE);

        $this->assertInstanceOf('FactureMensuelle', $facture);
    }

    function test_givenCustomerWithFactureHebdomadaireMensuelle_whenGenerateFacture_thenFactureAreFactureHebdomadaire(){
        $facture = $this->customer_with_facture_hebdomadaire->generate_next_time_facture($this->A_COTE, $this->A_SEMAINE);

        $this->assertInstanceOf('FactureHebdomadaire', $facture);
    }
}