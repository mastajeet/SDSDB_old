<?php
namespace SDSApi;
include_once('exceptions/ValueNotFoundException.php');
include_once('exceptions/MissingValueException.php');
include_once('resourceRequestBuilder/ThreeNextWorkingWeekShiftRequestBuilder.php');
include_once('resourceFormatter/shiftFormatter.php');


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
            }
        }

        if(is_null($resourceRequest)){
            throw new ValueNotFoundException("");
        }
        return $resourceRequest;
    }

    function formatResourceSet($resourceSet){
        return $this->resourceFormater->formatRecordSet($resourceSet);

    }
}