<?php
namespace SDSApi;

use DateInterval;


include_once('resourceRequestBuilder/ResourceRequestBuilder.php');

class CurrentWorkingWeekShiftRequestBuilder implements ResourceRequestBuilder {
    private $employeeId;
    private $timeService;

    function __construct($employeeId, $timeService){
        $this->employeeId = $employeeId;
        $this->timeService = $timeService;
    }

    public function buildRequest()
    {
        $currentWeek = $this->getCurrentWeekTimestamp();
        $employeId = $this->employeeId;
        $request = "SELECT shift.IDShift, Semaine, Jour, IDInstallation, Start, End, Warn, Message, IDEmploye, IDEmployeS, IDEmployeE
                    FROM shift LEFT JOIN remplacement 
                    ON shift.IDShift = remplacement.IDShift 
                    WHERE (IDEmploye = ".$employeId."  OR IDEmployeS = ".$employeId.") AND Semaine = ".$currentWeek." 
                    ORDER BY Jour ASC, `Start` ASC";
        return $request;
    }

    private function getCurrentWeekTimestamp(){
        $week_1 = $this->timeService->get_start_of_week(new \DateTime());

        return $week_1->getTimestamp();
    }
}