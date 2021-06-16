<?php

namespace SDSApi;
use DateInterval;
use DateTime;
use JsonSerializable;

include_once('resourceFormatter/ResourceFormatter.php');
include_once('helpers/JsonfiableDateTime.php');

class WorkingInstallationFormatter implements ResourceFormatter
{
    public function formatRecordSet($recordSet)
    {
        $installations = array();
        foreach($recordSet as $record){
            $InstallationId = $record["IDInstallation"];
            if(!in_array($InstallationId, $installations)) {
                $installations[$InstallationId] = $this->formatRecord($record);
            }
        }
        return $installations;
    }

    public function formatRecord($record)
    {
        $installationId = $record["IDInstallation"];
        $weekDateTime = new JsonfiableDateTime("@".$record["Semaine"]);
        $wdayDateTime = clone $weekDateTime;
        $wdayDateTime->add(new DateInterval("P".$record["Jour"]."D"));
        $shiftStartDateTime = clone $wdayDateTime;
        $shiftEndDateTime = clone $wdayDateTime;
        $shiftStartDateTime->add(new DateInterval("PT".$record["Start"]."S"));
        $shiftEndDateTime->add(new DateInterval("PT".$record["End"]."S"));
        $installation = array(
            "installation_id" => $installationId,
            "shift_start" => $shiftStartDateTime,
            "shift_end" => $shiftEndDateTime
        );
        return $installation;
    }
}

