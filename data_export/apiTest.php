<?php
include_once('data_export/getAuthenticationToken.php');

$authorization_header = getAuthenticationToken();


//$url = "http://sdsdb_nginx_1/api/employees?number=90&company=1";
//$url = "http://sdsdb_nginx_1/api/employees?number=90&company=1";
//$url = "http://prod.qcnat.o2web.ws/api/employees?nas=281302976";


$url = "http://prod.qcnat.o2web.ws/api/people?email=".urlencode("rachelfournier@live.fr");


$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $authorization_header));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$employee = json_decode($result, true)['hydra:member'][0];
print_r($employee);
print_r($employee['firstName']);