<?php
require_once('view/invoice/display_invoice/billing_period/MonthlyBillingPeriodRenderer.php');
require_once('view/invoice/display_invoice/billing_period/WeeklyBillingPeriodRenderer.php');

class TestInvoiceItem extends PHPUnit_Framework_TestCase
{
    const UN_TIMESTAMP = "1176008400";
    private $content_array;

    /**
     * @before
     */
    function buildContentArray(){
        $this->content_array = array(
            'billing_period_datetime'=>new DateTime("@".self::UN_TIMESTAMP)
        );
    }

    function test_GivenBuiltMonthlyBillingPeriodRenderer_WhenRender_ObtainStringOfMonthName()
    {
        $renderer = new MonthlyBillingPeriodRenderer();
        $renderer->buildContent($this->content_array);

        $html_output = $renderer->render();

        $this->assertEquals("<span class=texte>April</span> \n", $html_output);
    }

    function test_GivenBuiltWeeklyBillingPeriodRenderer_WhenRender_ObtainStringOfEndPointsOfWeek()
    {
        $renderer = new WeeklyBillingPeriodRenderer(new TimeService());
        $renderer->buildContent($this->content_array);

        $html_output = $renderer->render();

        $this->assertEquals("<span class=texte>08-Apr-07 au 14-Apr-07</span> \n", $html_output);
    }
}
