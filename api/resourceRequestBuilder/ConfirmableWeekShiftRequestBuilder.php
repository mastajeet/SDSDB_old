<?php
namespace SDSApi;

use DateInterval;
use DateTime;

include_once('resourceRequestBuilder/ResourceRequestBuilder.php');

class ConfirmableWeekShiftRequestBuilder implements ResourceRequestBuilder {
    private $employeeId;
    private $timeService;

    function __construct($employeeId, $timeService){
        $this->employeeId = $employeeId;
        $this->timeService = $timeService;
    }

    public function buildRequest()
    {

        $currentWeek = $this->timeService->get_start_of_week(new DateTime());
        $currentDateTime = new DateTime();

        if(! $this->isTooLateToConfirmLastWeek($currentDateTime) ){
            $currentWeek->sub(new DateInterval("P7D")) ;
        }
        $currentWeek = $currentWeek->getTimestamp();

        $employeId = $this->employeeId;
        $request = "SELECT shift.IDShift, Semaine, Jour, IDInstallation, Start, End, Warn, Message, IDEmploye
                    FROM shift WHERE IDEmploye = ".$employeId."  AND Semaine = ".$currentWeek." 
                    ORDER BY Jour ASC, `Start` ASC";
        return $request;
    }

    private function isTooLateToConfirmLastWeek($currentDateTime){
        if($this->isTimeLaterThan9amOnMonday($currentDateTime) or $this->isDateLaterThanMonday($currentDateTime)){
            return true;
        }

        return false;
    }

    /**
     * @param DateTime $now
     * @return bool
     */
    private function isTimeLaterThan9amOnMonday(DateTime $now)
    {
        return $now->format("w") == 1 and $now->format("G") >= 9;
    }

    /**
     * @param DateTime $now
     * @return bool
     */
    private function isDateLaterThanMonday(DateTime $now)
    {
        return $now->format("w") > 1;
    }
}