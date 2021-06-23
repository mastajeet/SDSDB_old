<?php
# Installation depends on customer. This should be imported first
# Legacy_id from new software is the ID to use for mapping
# This is should be populated automatically in the new software.

namespace DataSync;
use DateTime;
use ForceUTF8\Encoding;
use Installation;
use Shift;

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
$weekToImport = new DateTime();
$weekToImport->sub(new \DateInterval("P7D"));

$currentWeekTimeStamp = $timeService->get_start_of_week($weekToImport)->getTimestamp();
$currentWeekBoundaries = $timeService->get_week_endpoints_from_timestamp($currentWeekTimeStamp);

$startOfWeek = $currentWeekBoundaries["start_of_week"]->format("c");
$endOfWeek =  $currentWeekBoundaries["end_of_week"]->format("c");


$existingConfirmation = "SELECT IDEmploye, IDConfirmation FROM confirmation where Semaine = ".$currentWeekTimeStamp;
$mysqlClient->Select($existingConfirmation);

$confirmationIds = [];
$confirmationIdsInListForSQL = "";
while($confirmationCursor = $mysqlClient->FetchAssoc()){
    $confirmationIds[$confirmationCursor['IDEmploye']] = $confirmationCursor['IDConfirmation'];
    $confirmationIdsInListForSQL .= ", ".$confirmationCursor['IDConfirmation'];
}
$confirmationIdsInListForSQL = substr($confirmationIdsInListForSQL,1);

$existingConfirmedShift = "SELECT IDConfirmation, IDShift FROM confshift where IDConfirmation in (".$confirmationIdsInListForSQL.")";

$mysqlClient->Select($existingConfirmedShift);
$confirmedShiftIds = [];

while($confirmationShiftCursor = $mysqlClient->FetchAssoc()){
    if(!array_key_exists($confirmationShiftCursor['IDConfirmation'], $confirmedShiftIds)){
        $confirmedShiftIds[$confirmationShiftCursor['IDConfirmation']] = [];
    }
    $confirmedShiftIds[$confirmationShiftCursor['IDConfirmation']][] = $confirmationShiftCursor['IDShift'];
}

$shiftConfirmationEndPointWithRequestParams = $shiftConfirmationEndPoint."?pagination=false&company=".$currentCompany."&datetimeStart[after]=".$startOfWeek."&datetimeEnd[before]=".$endOfWeek;

$shiftPayload = getRequest($shiftConfirmationEndPointWithRequestParams, $authToken);
$confirmationShifts = json_decode($shiftPayload, True)["hydra:member"];


foreach($confirmationShifts as $confirmationShift){
    $shiftId = $confirmationShift["shift"]["legacyId"];
    $employeeId = $confirmationShift["employee"]["number"];
    $JsonDatetimeShiftStart = $confirmationShift["dateTimeStart"] ;
    $JsonDatetimeShiftEnd = $confirmationShift["dateTimeEnd"];
    $employee = new \Employee($employeeId);
    if(!array_key_exists($employeeId, $confirmationIds)){

        print("Ajout d'une confirmation pour ".$employee->getHoraireName());
        print("<br>");

        $insertConfirmationQuery = "INSERT INTO confirmation(`IDEmploye`,`Semaine`,`Confirme`) VALUES(".$employeeId.",".$currentWeekTimeStamp.",0)";
        $mysqlClient->Insert($insertConfirmationQuery);
        $selectConfirmationIdQuery = "SELECT IDConfirmation FROM confirmation WHERE IDEmploye = ".$employeeId." ORDER BY IDConfirmation DESC LIMIT 0,1 ";
        $mysqlClient->Select($selectConfirmationIdQuery);
        while($cursor = $mysqlClient->FetchAssoc()){
            $confirmationId = $cursor["IDConfirmation"];
        }
        $confirmedShiftIds[$confirmationId] = [];
    }else{
        $confirmationId = $confirmationIds[$employeeId];
    }

    $confirmationShiftIdsForEmployee = $confirmedShiftIds[$confirmationId];
    if(!in_array($shiftId ,$confirmationShiftIdsForEmployee)){
        $timestampStart = new DateTime($JsonDatetimeShiftStart);
        $timestampEnd = new DateTime($JsonDatetimeShiftEnd);

        $shiftStart = intval(date_format($timestampStart,"G"))*3600+intval(date_format($timestampStart, "i")*60);
        $shiftEnd = intval(date_format($timestampEnd,"G"))*3600+intval(date_format($timestampEnd, "i")*60);

        $insertConfirmationQuery = "INSERT INTO confshift(`IDConfirmation`,`IDShift`,`Start`,`End`) VALUES(".$confirmationId.",".$shiftId.",".$shiftStart.",".$shiftEnd.")";
        $mysqlClient->Insert($insertConfirmationQuery);
        $shift = new Shift($shiftId, new \TimeService());
        $installation = new Installation($shift->IDInstallation);

        print("Shift ajouté: ". $installation->Nom." de ".date_format($timestampStart,"D G:i")." à ".date_format($timestampEnd,"G:i")." (".$employee->getHoraireName().") <br>");
    }
}



