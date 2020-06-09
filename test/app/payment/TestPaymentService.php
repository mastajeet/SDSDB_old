<?php

include_once ('app/payment/paymentService.php');
include_once('app/invoice/InvoiceService.php');
include_once ('app/payment/payment.php');

class TestPaymentService extends PHPUnit_Framework_TestCase{

    private $payment_service;
    private $A_COTE = "TPS";
    /**
     * @before
     */
    function setUp(){
//        $facture_service = getMockBuilder(FactureService::class);
        $this->facture_service =  new InvoiceService("Notes","0","0");
        $this->payment_service = new PaymentService($this->facture_service);

    }

    function test_givenPaymentObject_whenDeletePayment_thenPaymentIsRemovedFromDatabase(){

        $payment_information = Array(
            "Cote"=>"TPS",
            "Notes"=>" Paye:~TPS-1~",
            "Date"=>"1529812800"
        );
        $payment_date = new DateTime("@".$payment_information['Date']);
        $payment_dto = Array(
            "Cote"=>"$this->A_COTE",
            "Date"=> $payment_date
        );
        $payment = new Payment($payment_information);
        $payment->save();

        try {
            $payments = $this->payment_service->get_payments($payment_dto);
            $this->assertEquals(1, count($payments));
        }catch (Exception $exception){
            $this->payment_service->delete_payment($payment);
            throw new AssertionError();
        }


        $this->payment_service->delete_payment($payment);

        $payments = $this->payment_service->get_payments($payment_dto);
        $this->assertEquals(0, count($payments));
    }

    function test_givenPaymentPayingFacture_whenAddPayment_thenFactureIsPaid(){
        $facture = $this->facture_service->get_shift_and_materiel_facture_by_cote_and_sequence("TPS",1);
        $facture->mark_unpaid();
        $facture->save();
        $payment_information = Array(
            "Cote"=>"TPS",
            "Notes"=>" Paye:~TPS-1~",
            "Date"=>"1529812800"
        );
        $payment = new Payment($payment_information);

        $this->payment_service->add_payment($payment);
        $payment->destroy(); // genre de tear down du test

        $paid_facture = $this->facture_service->get_shift_and_materiel_facture_by_cote_and_sequence("TPS",1);
        $this->assertEquals(True, $paid_facture->is_paid());
    }

    function test_givenPaymentPayingFacture_whenDeletePayment_thenFactureIsUnpaid(){
        $facture = $this->facture_service->get_shift_and_materiel_facture_by_cote_and_sequence("TPS",1);
        $facture->mark_paid();
        $facture->save();
        $payment_information = Array(
            "Cote"=>"TPS",
            "Notes"=>" Paye:~TPS-1~",
            "Date"=>"1529812800"
        );
        $payment = new Payment($payment_information);
        $payment->save();

        $this->payment_service->delete_payment($payment);

        $unpaid_facture = $this->facture_service->get_shift_and_materiel_facture_by_cote_and_sequence("TPS",1);
        $this->assertEquals(False, $unpaid_facture->is_paid());
    }


    function test_givenCoteAndDate_whenFindPayments_thenPaymentArrayIsReturned(){
        $timestamp = 1530629972;
        $date = new DateTime("@".$timestamp);
        $payment_dto = Array(
            "Cote"=>"$this->A_COTE",
            "Date"=> $date
        );
        $payments = $this->payment_service->get_payments($payment_dto);

        $this->assertEquals(2, count($payments));
    }
}
