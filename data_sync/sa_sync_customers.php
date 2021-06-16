<?php
# Installation depends on customer. This should be imported first
# Legacy_id from new software is the ID to use for mapping
# This is should be populated automatically in the new software.

namespace DataSync;
use ForceUTF8\Encoding;

#include_once('mysql_class_qc.php');
include_once('data_sync/getAuthenticationToken.php');
include_once('getRequest.php');
include_once('forceutf8/Encoding.php');

# const BASE_PATH = "http://sdsdb_docker_nginx_1";
const BASE_PATH = "http://prod.qcnat.o2web.ws";
const CUSTOMER_API_ENDPOINT = "/api/customers";
const INSTALLATION_API_ENDPOINT ="/api/installations";


$confirmInsert = false;
if(isset($_GET['confirm'])){
    $confirmInsert = true;
}
$currentCompany = $_COOKIE["companyId"];
$authToken = getAuthenticationToken();

$customerEndPoint = BASE_PATH . CUSTOMER_API_ENDPOINT;
$installationEndPoint = BASE_PATH . INSTALLATION_API_ENDPOINT;

$mysqlClient = new \SqlClass();
$customerQuery = "SELECT IDClient FROM client where 1";
$installationQuery = "SELECT IDInstallation FROM installation where 1";

$mysqlClient->Select($customerQuery);
$customerIds = [];
while($customerCursor = $mysqlClient->FetchAssoc()){
    $customerIds[] = $customerCursor['IDClient'];
}

$installationIds =[];
$mysqlClient->Select($installationQuery);
while($installationCursor = $mysqlClient->FetchAssoc()){
    $installationIds[] = $installationCursor['IDInstallation'];
}

$customersPayload = getRequest($customerEndPoint, $authToken);
$customersLastPage = json_decode($customersPayload, True)["hydra:view"]["hydra:last"];

$customersPayload = getRequest(BASE_PATH.$customersLastPage, $authToken);

$installationPayLoad = getRequest($installationEndPoint, $authToken);
$installationLastPage = json_decode($installationPayLoad, True)["hydra:view"]["hydra:last"];
$installationPayLoad = getRequest(BASE_PATH.$installationLastPage, $authToken);


$customers = json_decode($customersPayload, True)["hydra:member"];
$installations = json_decode($installationPayLoad, True)["hydra:member"];

$customerIdMapping =[];

foreach($customers as $customer){
    $id = $customer["id"];
    $legacyId = $customer["legacyId"];
    $companyId = $customer["company"]["id"];
    $nom = Encoding::toLatin1($customer["name"]);
    $customerIdMapping[$id] = $legacyId;
    if($companyId==$currentCompany and !in_array($legacyId, $customerIds)) {
        $customerInsertRequest = "INSERT INTO client(`IDClient`,`Nom`,`Actif`,`FrequenceFacturation`,`Facturation`) VALUES(".$legacyId.",'".addslashes($nom)."',1,'H','E')";
        if($confirmInsert) {
            $mysqlClient->Insert($customerInsertRequest);
        }else{
            print("Client à ajouter: ".$nom."<br>");

        }

    }
}

foreach($installations as $installation){
    $legacyId = $installation["legacyId"];
    $companyId= explode("/",$installation["customer"]["company"])[3];
    $customerId= $installation["customer"]["id"];
    $nom = addslashes(Encoding::toLatin1($installation["name"]));
    $cote = $installation["billingCode"]["code"];
    if($companyId==$currentCompany and !in_array($legacyId, $installationIds)) {
        $customerLegacyId = $customerIdMapping[$customerId];

        if($confirmInsert) {
            $horaireInstallationRequest = "INSERT into horaire(`Nom`) VALUES('".$nom."')";
            $mysqlClient->Insert($horaireInstallationRequest);
            $lastHoraireIdRequest = "SELECT IDHoraire from horaire order by IDHoraire DESC LIMIT 0,1";
            $mysqlClient->Select($lastHoraireIdRequest);
            while($rep = $mysqlClient->FetchAssoc()){
                $horaire_id = $rep["IDHoraire"];
            }

            $installationInsertRequest = "INSERT INTO installation(`IDInstallation`,`IDClient`,`IDHoraire`,`Cote`,`Nom`,`Actif`,`Saison`) VALUES(".$legacyId.",".$customerLegacyId.",".$horaire_id.",'".$cote."','".$nom."',1,1)";
            $mysqlClient->Insert($installationInsertRequest);

        }else{
            print("Piscine à ajouter:".$nom."[".$cote."] <br>");

        }
        #
    }
}
print("<a href=index.php?Section=SuperAdmin&ToDo=syncCustomers&confirm=true>confirmer</a>");
