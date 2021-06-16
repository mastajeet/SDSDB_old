<?php
namespace SDSApi;

use DateInterval;


include_once('resourceRequestBuilder/ResourceRequestBuilder.php');

class WorkingLocationRequestBuilder implements ResourceRequestBuilder
{
    private $employeeId;
    private $timeService;

    function __construct($employeeId, $timeService)
    {
        $this->employeeId = $employeeId;
        $this->timeService = $timeService;
    }

    public function buildRequest()
    {
        $nextWeeksTimeStamp = $this->getWeekTimestampInListForSql();
        $employeId = $this->employeeId;
        $request = "SELECT IDInstallation, Semaine, Jour, Start, End, Warn, Message, IDEmploye, IDEmployeS, IDEmployeE
                    FROM shift LEFT JOIN remplacement 
                    ON shift.IDShift = remplacement.IDShift 
                    WHERE (IDEmploye = " . $employeId . "  OR (IDEmployeS = " . $employeId . " AND IDEmployeE=0)) AND Semaine in (" . $nextWeeksTimeStamp . ") 
                    ORDER BY Jour ASC, `Start` ASC";
        return $request;
    }

    private function getWeekTimestampInListForSql()
    {
        $week_1 = $this->timeService->get_start_of_week(new \DateTime());
        $week_2 = $this->timeService->get_start_of_week(new \DateTime())->add(new DateInterval("P7D"));
        $week_3 = $this->timeService->get_start_of_week(new \DateTime())->add(new DateInterval("P14D"));

        $timestampInList = $week_1->getTimestamp() . ", " . $week_2->getTimestamp() . ", " . $week_3->getTimestamp();

        return $timestampInList;
    }
}