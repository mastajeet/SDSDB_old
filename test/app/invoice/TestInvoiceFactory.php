<?php

include_once('app/invoice/invoiceFactory.php');
include_once('app/invoice/invoice.php');

include_once('app/invoice/shiftInvoice.php');
include_once('app/invoice/equipmentInvoice.php');
include_once('app/invoice/Credit.php');
include_once('app/invoice/avanceClient.php');

class TestInvoiceFactory extends PHPUnit_Framework_TestCase{

    private $facture_factory;

    /**
     * @before
     */
    function setUp(){
        $this->facture_factory = new InvoiceFactory();
    }

    function test_givenWeeklyFactureOfShift_whenGetTypedFacture_thenGetShiftFactureObject(){
        $facture = new Invoice(3010);
        $shift_facture = $this->facture_factory->getTypedInvoice($facture);

        $this->assertInstanceOf('ShiftInvoice', $shift_facture);
//        $this->assertInstanceOf('WeeklyInvoice', $shift_facture);
        $this->assertEquals($shift_facture->Sequence, 1);
    }

    function test_givenMonthlyFactureOfShift_whenGetTypedFacture_thenGetShiftFactureObject(){
        $facture = new Invoice(3014);
        $shift_facture = $this->facture_factory->getTypedInvoice($facture);

        $this->assertInstanceOf('ShiftInvoice', $shift_facture);
//        $this->assertInstanceOf('MonthlyInvoice', $shift_facture);
        $this->assertEquals($shift_facture->Sequence, 1);
    }

    function test_givenFactureOfMateriel_whenGetTypedFacture_thenGetFactureMaterielObject(){
        $facture = new Invoice(3011);
        $facture_materiel = $this->facture_factory->getTypedInvoice($facture);

        $this->assertInstanceOf('EquipmentInvoice', $facture_materiel);
    }

    function test_givenFactureCredit_whenGetTypedFacture_thenGetCreditObject(){
        $facture = new Invoice(3012);
        $credit = $this->facture_factory->getTypedInvoice($facture);

        $this->assertInstanceOf('Credit', $credit);
    }

    function test_givenFactureOfAvanceClient_whenGetTypedFacture_thenGetAvanceClientObject(){
        $facture = new Invoice(3013);
        $avance_client = $this->facture_factory->getTypedInvoice($facture);

        $this->assertInstanceOf('AvanceClient', $avance_client);
    }

}
