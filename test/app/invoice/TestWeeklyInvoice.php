<?php

include_once('app/invoice/weeklyInvoice.php');
include_once('app/invoice/invoice.php');
include_once ('app/payment/payment.php');

class TestWeeklyInvoice extends PHPUnit_Framework_TestCase
{
    function test_givenMonthlyInvoiceForMonthStartingOnSunday_whenGetBegginingOfBillingPeriod_thenGetTheSameDay()
    {
        $facture = new WeeklyInvoice(array("Semaine"=>"1583020800")); #1 mars 2020
        $first_day_of_month = new DateTime("@"."1583020800"); #1 mars 2020

        $this->assertEquals($first_day_of_month, $facture->getBeginningOfBillablePeriod());
    }

    function test_givenWeeklyInvoiceForMonthNotStartingOnSunday_whenGetBegginingOfBillingPeriod_thenGetTheSameDay()
    {
        $facture = new WeeklyInvoice(array("Semaine"=>"1595721600")); #26 juillet 2020
        $first_day_of_month = new DateTime("@"."1595721600"); #1 août 2020

        $this->assertEquals($first_day_of_month, $facture->getBeginningOfBillablePeriod());
    }
}
