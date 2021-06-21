<?php

error_reporting(E_STRICT);
//ini_set('display_errors', );
$DEV = TRUE;
include_once("forceutf8/Encoding.php");
include_once('data_export/database_hardcoded_ids');
include_once('data_export/DTOGenerators.php');
include_once('data_export/postRequest.php');
include_once('data_export/getAuthenticationToken.php');
include_once('data_export/handleApiViolations.php');
include_once('data_export/getPersonEntity.php');
include_once('data_export/remoteApiEndPoints.php');
include_once('mysql_class_qc.php');


const TELEPHONE_MAISON_IRI = "api/person_phone_number_types/1";
const TELEPHONE_CELLULAIRE_IRI = "api/person_phone_number_types/2";

const SDS_QC_IRI = "api/companies/1";

$get_employees_query = "SELECT * FROM employe ORDER BY IDEmploye ";