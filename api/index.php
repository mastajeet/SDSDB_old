<?php
namespace SDSApi;
use TimeService;
ini_set('display_errors', 1);
ini_set('display_errors', E_ALL);
setlocale(LC_TIME, 'fr_CA');
date_default_timezone_set ('America/Montreal');
include_once('exceptions/MissingValueException.php');
include_once('exceptions/ValueNotFoundException.php');
include_once('helpers/ApiConnectionBaseInfo.php');
include_once('helpers/ConnectionClient.php');
include_once('helpers/ResourceInfo.php');

include_once('../helper/TimeService.php');

$method = $_SERVER['REQUEST_METHOD'];
$timeService = new TimeService();


if ($method == "GET") {

    $apiBaseInfo = new ApiConnectionBaseInfo($_GET);
    $resourceInfo = new ResourceInfo($_GET, $timeService);
    if($apiBaseInfo->isAuthorized()){
        $client = new ConnectionClient($apiBaseInfo);
        try{
            $ressourceRequest = $resourceInfo->getResourceRequest($_GET);
            $requestedSet = $client->get($ressourceRequest->buildRequest());
            $formatedResource = $resourceInfo->formatResourceSet($requestedSet);

            print(json_encode($formatedResource));
            http_response_code(200);
        }catch(MissingValueException $e){
            http_response_code(401);
            print(json_encode($e));
        }catch(ValueNotFoundException $e){
            http_response_code(404);
            print(json_encode($e));
        }
    }else{
        http_response_code(403);
    }
} else {
    http_response_code(405);
}