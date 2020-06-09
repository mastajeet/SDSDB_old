<?php

include_once ('app/customer.php');
include_once('app/invoice/invoice.php');
include_once ('app/shift.php');
include_once ('helper/TimeService.php');
include_once('app/invoice_item/timedInvoiceItem.php');
include_once('constants.php');

class TestShift extends PHPUnit_Framework_TestCase
{

    private $A_WEEK_TIMESTAMP = 1541912400;

    /**
     * @before
     */
    function setup_tested_instance(){
        $this->facture = new Invoice(array('Semaine'=>$this->A_WEEK_TIMESTAMP));
        $this->customer = new Customer(17);
    }

    function test_GivenFactureDatingFrom2Weeks_whenAddingShift_thenAddedShiftHasJourShiftedForTwoWeeks(){
        $shift = new Shift(array('Semaine'=>1543122000, 'Jour'=>4, 'IDInstallation'=>21), new TimeService());
        $shift->add_to_facture($this->facture);

        $expected_jour = 2*7 + $shift->Jour;
        $actual_jour = $this->facture->Factsheet[0]->Jour;

        $this->assertEquals($expected_jour, $actual_jour);
    }

    function test_GivenFactureFromCurrentWeek_whenAddingShiftFromCurrentWeek_thenAddedShiftHasSameJour(){
        $shift = new Shift(array('Semaine'=>1541912400, 'Jour'=>4, 'IDInstallation'=>21), new TimeService());
        $shift->add_to_facture($this->facture);

        $expected_jour = $shift->Jour;
        $actual_jour = $this->facture->Factsheet[0]->Jour;

        $this->assertEquals($expected_jour, $actual_jour);
    }
}