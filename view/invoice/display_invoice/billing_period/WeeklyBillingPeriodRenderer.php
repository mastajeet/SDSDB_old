<?php
include_once('view/HTMLContainerRenderer.php');

class WeeklyBillingPeriodRenderer extends HTMLContainerRenderer
{
    private $time_service;

    function __construct(TimeService $time_service)
    {
        $this->time_service = $time_service;
        parent::__construct();
    }

    function buildContent($content_array)
    {
        $datetime = $content_array['billing_period_datetime'];
        $end_points = $this->time_service->get_week_endpoints_from_timestamp($datetime->getTimestamp());
        $start_of_week = date_Format($end_points['start_of_week'], "d-M-y");
        $end_of_week = date_Format($end_points['end_of_week'], "d-M-y");
        $this->html_container->addtexte($start_of_week." au ".$end_of_week);
    }
}
