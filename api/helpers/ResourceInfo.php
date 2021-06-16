<?php
namespace SDSApi;
include_once('exceptions/ValueNotFoundException.php');
include_once('exceptions/MissingValueException.php');
include_once('resourceRequestBuilder/ThreeNextWorkingWeekShiftRequestBuilder.php');
include_once('resourceRequestBuilder/WorkingLocationRequestBuilder.php');
include_once('resourceRequestBuilder/CurrentWorkingWeekShiftRequestBuilder.php');
include_once('resourceFormatter/ShiftFormatter.php');
include_once('resourceFormatter/WorkingInstallationFormatter.php');

use TimeService;

class ResourceInfo{

    private $resourceName;
    private $timeService;
    private $resourceFormater;

    function __construct($request, TimeService $timeService){
        $this->resourceName = $request["resource"];
        $this->timeService = $timeService;
    }

    function getResourceRequest($request){
        $resourceRequest = null;

        if($this->resourceName == "shift"){
            $set = strtolower($request["set"]);
            switch($set){
                CASE "3next":
                    if(!isset($request["employee_id"])){
                        throw new MissingValueException("employee_id");
                    }
                    $employeeId = intval($request["employee_id"]);
                    $resourceRequest = new ThreeNextWorkingWeekShiftRequestBuilder($employeeId,$this->timeService );
                    $this->resourceFormater = new shiftFormatter();
                    break;
                CASE "1last":
                    if(!isset($request["employee_id"])){
                        throw new MissingValueException("employee_id");
                    }
                    $employeeId = intval($request["employee_id"]);
                    $resourceRequest = new LastWorkingWeekShiftRequestBuilder($employeeId,$this->timeService);
                    $this->resourceFormater = new shiftFormatter();
                    break;

                CASE "currentweek":
                    if(!isset($request["employee_id"])){
                        throw new MissingValueException("employee_id");
                    }
                    $employeeId = intval($request["employee_id"]);
                    $resourceRequest = new CurrentWorkingWeekShiftRequestBuilder($employeeId,$this->timeService);
                    $this->resourceFormater = new shiftFormatter();
                    break;

            }
        }elseif($this->resourceName == "installation"){
            $set = strtolower($request["set"]);
            switch($set){
                CASE "nextworking":{
                    if(!isset($request["employee_id"])){
                        throw new MissingValueException("employee_id");
                    }
                    $resourceRequest = new WorkingLocationRequestBuilder($request["employee_id"],$this->timeService);
                    $this->resourceFormater = new WorkingInstallationFormatter();
                    break;
                }
            }
        }

        if(is_null($resourceRequest)){
            throw new ValueNotFoundException("resource: ".$this->resourceName." \n set: ".$request["set"]);
        }

        return $resourceRequest;
    }

    function formatResourceSet($resourceSet){
        return $this->resourceFormater->formatRecordSet($resourceSet);
    }
}