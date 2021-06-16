<?php


namespace SDSApi;
use DateInterval;
use DateTime;
use JsonSerializable;

include_once('resourceFormatter/ResourceFormatter.php');
include_once('helpers/JsonfiableDateTime.php');


class ShiftFormatter implements ResourceFormatter
{
    public function formatRecordSet($recordSet)
    {
        $shifts = array();
        foreach($recordSet as $record){
            $shifts[] = $this->formatRecord($record);
        }
        return $shifts;
    }

    public function formatRecord($record)
    {
        $color = "ok";
        $message = null;
        if ($record["Warn"] <> "") {
            $message = "Appelle nous!";
            $color = "warning";
        } elseif($record["Message"]<>""){
            $message = $record["Message"];
            $color = "warning";
        }
        if (is_null($record["IDEmployeS"])) {
            $employee_id = $record["IDEmploye"];
            $replacement = null;

        } else {
            $employee_id = $record["IDEmployeS"];
            $color = "replacement";
            if (!is_null($record["IDEmployeE"])) {
                $replacement = $record["IDEmployeE"];
            } else {
                $replacement = null;
            }
        }

        $weekDateTime = new JsonfiableDateTime("@".$record["Semaine"]);
        $wdayDateTime = clone $weekDateTime;
        $wdayDateTime->add(new DateInterval("P".$record["Jour"]."D"));
        $shiftStartDateTime = clone $wdayDateTime;
        $shiftEndDateTime = clone $wdayDateTime;


        $shiftStartDateTime->add(new DateInterval("PT".$record["Start"]."S"));
        $shiftEndDateTime->add(new DateInterval("PT".$record["End"]."S"));
        $shift = array(
            "legacy_id"=> $record["IDShift"],
            "employee_id" => $employee_id,
            "installation_id" => $record["IDInstallation"],
            "week" => $wdayDateTime,
            "day" => $wdayDateTime,
            "shift_start" =>$shiftStartDateTime,
            "shift_end" =>$shiftEndDateTime,
            "color" => $color,
            "message" => $message,
            "replacement" => $replacement
        );
        return $shift;
    }
}

