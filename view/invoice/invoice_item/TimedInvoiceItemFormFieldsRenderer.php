<?php

class TimedInvoiceItemFormFieldsRenderer extends HTMLContainerRenderer
{
    private $day_array;

    function __construct($day_array)
    {
        $this->day_array = $day_array;
        parent::__construct();
    }

    function buildContent($content_array)
    {
        $start = getOrDefault($content_array["start"],"");
        $end = getOrDefault($content_array["end"],"");
        $notes = getOrDefault($content_array["notes"],"");
        $hourly_rate = getOrDefault($content_array["hourly_rate"],null);
        $day = getOrDefault($content_array["day"],-1);

        $this->html_container->inputtext("start","Début",2, $start);
        $this->html_container->inputtext("end", "Fin",2, $end);
        $this->html_container->inputtext("notes", "Notes",28, $notes);
        $this->html_container->inputtext("hourly_rate", "Taux Horaire",4, $hourly_rate);
        $this->html_container->inputselect("day", $this->day_array,$day,"Jour");
    }
}
