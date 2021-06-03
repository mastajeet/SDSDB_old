<?php
namespace SDSApi;

use DateInterval;


include_once('resourceRequestBuilder/ResourceRequestBuilder.php');

class ThreeNextWorkingWeekShiftRequestBuilder implements ResourceRequestBuilder {
    private $employeeId;
    private $timeService;

    function __construct($employeeId, $timeService){
        $this->employeeId = $employeeId;
        $this->timeService = $timeService;
    }

    public function buildRequest()
    {
        $weekListForSql = $this->getWeekTimestampInListForSql();
        $employeId = $this->employeeId;
        $request = "SELECT shift.IDShift, Semaine, Jour, IDInstallation, Start, End, Warn, Message, IDEmploye, IDEmployeS, IDEmployeE
                    FROM shift LEFT JOIN remplacement 
                    ON shift.IDShift = remplacement.IDShift 
                    WHERE (IDEmploye = ".$employeId."  OR IDEmployeS = ".$employeId.") AND Semaine in (".$weekListForSql.") 
                    ORDER BY Jour ASC, `Start` ASC";
        return $request;
    }

    private function getWeekTimestampInListForSql(){
        $week_1 = $this->timeService->get_start_of_week(new \DateTime());
        $week_2 = $this->timeService->get_start_of_week(new \DateTime())->add(new DateInterval("P7D"));
        $week_3 = $this->timeService->get_start_of_week(new \DateTime())->add(new DateInterval("P14D"));

        $timestampInList = $week_1->getTimestamp().", ".$week_2->getTimestamp().", ".$week_3->getTimestamp();

        return $timestampInList;
    }
}