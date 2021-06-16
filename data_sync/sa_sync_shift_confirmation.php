<?php
# Installation depends on customer. This should be imported first
# Legacy_id from new software is the ID to use for mapping
# This is should be populated automatically in the new software.

namespace DataSync;
use DateTime;
use ForceUTF8\Encoding;

#include_once('mysql_class_qc.php');
include_once('data_sync/getAuthenticationToken.php');
include_once('getRequest.php');
include_once('forceutf8/Encoding.php');

# const BASE_PATH = "http://sdsdb_docker_nginx_1";
const BASE_PATH = "http://prod.qcnat.o2web.ws";
const SHIFT_CONFIRMATION_ENDPOINT = "/api/shift_confirmations";


$confirmInsert = false;
if(isset($_GET['confirm'])){
    $confirmInsert = true;
}
$currentCompany = $_COOKIE["companyId"];
$authToken = getAuthenticationToken();

$shiftConfirmationEndPoint = BASE_PATH . SHIFT_CONFIRMATION_ENDPOINT;


$mysqlClient = new \SqlClass();
$timeService = new \TimeService();
$currentWeekTimeStamp = $timeService->get_start_of_week(new DatimeTime())->getTimestamp();
$currentWeekBoundaries = $timeService->get_week_endpoints_from_timestamp($currentWeekTimeStamp);

$workingEmployeeQuery = "SELECT distinct IDEmployee FROM shift where Semaine = ".$currentWeekTimeStamp;
$mysqlClient->Select($workingEmployeeQuery);

$employeeIds = [];
while($shiftCursor = $mysqlClient->FetchAssoc()){
    $employeeIds[] = $shiftCursor['IDEmployee'];
}

$existingConfirmation = "SELECT IDEmployee, IDConfirmation FROM confirmation where Semaine = ".$currentWeekTimeStamp;
$mysqlClient->Select($existingConfirmation);

$confirmationIds = [];
$confirmationIdsInListForSQL = "";
while($confirmationCursor = $mysqlClient->FetchAssoc()){
    $confirmationIds[$confirmationCursor['IDEmployee']] = $confirmationCursor['IDConfirmation'];
    $confirmationIdsInListForSQL .= ", ".$confirmationCursor['IDConfirmation'];
}
$confirmationIdsInListForSQL = substr($confirmationIdsInListForSQL,1);

$existingConfirmedShift = "SELECT IDConfirmation, IDshift FROM confshift where IDConfirmation in (".$confirmationIdsInListForSQL.")";
$mysqlClient->Select($existingConfirmedShift);
$confirmedShiftIds = [];
while($confirmationShiftCursor = $mysqlClient->FetchAssoc()){
    $confirmedShiftIds[$confirmationShiftCursor['IDConfirmation']] = [];
    $confirmedShiftIds[$confirmationShiftCursor['IDConfirmation']][] = $confirmationShiftCursor['IDShift'];
}

$shiftConfirmationEndPointWithRequestParams = $shiftConfirmationEndPoint."?pagination=false&company=".$currentCompany."&datetimeStart=".$currentWeekBoundaries["start_of_week"]."&datetimeEnd=".$currentWeekBoundaries["end_of_week"];
$shiftPayload = getRequest($shiftConfirmationEndPointWithRequestParams, $authToken);
$confirmationShifts = json_decode($shiftPayload, True)["hydra:member"];

foreach($confirmationShifts as $confirmationShift){
    $shiftId = $confirmationShift["legacy_id"];
    $employeeId = $confirmationShift["employee"]["number"];
    $JsonDatetimeShiftStart = $confirmationShift["datetimeStart"] ;
    $JsonDatetimeShiftEnd = $confirmationShift["datetimeStart"];

    if(!in_array($employeeId, $confirmationIds)){
        $insertConfirmationQuery = "INSERT INTO confirmation(`IDEmploye`,`Semaine`,`Confirme`) VALUES(".$employeeId.",".$currentWeekTimeStamp.",1)";
        $mysqlClient->Insert($insertConfirmationQuery);
        $selectConfirmationIdQuery = "SELECT IDConfirmation FROM confirmation WHERE IDEmploye = ".$employeeId;
        $mysqlClient->Select($selectConfirmationIdQuery);
        while($cursor = $mysqlClient->FetchAssoc()){
            $confirmationId = $cursor["IDConfirmation"];
        }
    }else{
        $confirmationId = $confirmationIds[$employeeId];
    }

    $confirmationShiftIdsForEmployee = $confirmedShiftIds[$confirmationId];
    if(!in_array($shiftId ,$confirmationShiftIdsForEmployee)){
        $timestampStart = new DateTime($JsonDatetimeShiftStart);
        $timestampEnd = new DateTime($JsonDatetimeShiftEnd);

        $shiftStart = intval(date_format($timestampStart,"G"))+intval(date_format($timestampStart, "i"));
        $shiftEnd = intval(date_format($timestampEnd,"G"))+intval(date_format($timestampEnd, "i"));

        $insertConfirmationQuery = "INSERT INTO confshift(`IDConfirmation`,`IDShift`,`IDEmploye`,`Start`,`End`) VALUES(".$confirmationId.",".$shiftId.",".$employeeId.",".$shiftStart.",".$shiftEnd.")";
        $mysqlClient->Insert($insertConfirmationQuery);
    }
}



