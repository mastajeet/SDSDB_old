<?php

include_once('app/customer.php');

class TestCustomer extends PHPUnit_Framework_TestCase
{

    private $A_COTE = "ABC";
    private $A_SEMAINE = null;
    private $A_YEAR = 2018;
    private $A_TOLERANCE = 0.1;

    private $A_CUSTOMER_ID_WITH_3_INSTALLATION_3_COTES = "60";
    private $A_CUSTOMER_ID_WITH_3_INSTALLATION_2_COTES = "65";

    /**
     * @before
     */
    function setup_tested_instance(){
        $this->A_SEMAINE = new DateTime();
        $this->A_SEMAINE->setDate(2018,7,31);
    }

    function test_givenCustomerWithFactureMensuelle_whenGenerateFacture_thenFactureAreFactureMensuelle(){
        $customer_with_facture_mensuelle = new Customer(17);
        $facture = $customer_with_facture_mensuelle->generate_next_time_facture($this->A_COTE, $this->A_SEMAINE);

        $this->assertInstanceOf('MonthlyInvoice', $facture);
    }

    function test_givenCustomerWithFactureHebdomadaireMensuelle_whenGenerateFacture_thenFactureAreFactureHebdomadaire(){
        $customer_with_facture_hebdomadaire = new Customer(1);
        $facture = $customer_with_facture_hebdomadaire->generate_next_time_facture($this->A_COTE, $this->A_SEMAINE);

        $this->assertInstanceOf('WeeklyInvoice', $facture);
    }

    function test_givenCustomerWithOutstandingBalance_whenHasOutstadingBalance_thenReturnTrue(){
        $customer_with_outstanding_balance = new Customer(17);

        $this->assertTrue($customer_with_outstanding_balance->has_outstanding_balance($this->A_YEAR, $this->A_TOLERANCE));
    }

    function test_givenCustomerWithoutOutstandingBalance_whenHasOutstadingBalance_thenReturnFalse(){
        $customer_with_outstanding_balance = new Customer(18);

        $this->assertFalse($customer_with_outstanding_balance->has_outstanding_balance($this->A_YEAR, $this->A_TOLERANCE));
    }

    function test_givenCustomerWith3InstallationWith3DifferentCote_whenGetDossierFacturation_thenGet3Dossier(){
        $customer_with_3_installations_3_cotes = new Customer($this->A_CUSTOMER_ID_WITH_3_INSTALLATION_3_COTES);
        $customer_with_3_installations_3_cotes->get_dossiers_facturation($this->A_YEAR);

        $this->assertEquals(3, count($customer_with_3_installations_3_cotes->dossier_facturation));
    }

    function test_givenCustomerWith3InstallationWith2DifferentCote_whenGetDossierFacturation_thenGet2Dossier(){
        $customer_with_3_installations_3_cotes = new Customer($this->A_CUSTOMER_ID_WITH_3_INSTALLATION_2_COTES);
        $customer_with_3_installations_3_cotes->get_dossiers_facturation($this->A_YEAR);

        $this->assertEquals(2, count($customer_with_3_installations_3_cotes->dossier_facturation));
    }
}