<?php

    error_reporting(E_STRICT);
//ini_set('display_errors', );

include_once("forceutf8/Encoding.php");
include_once('data_export/database_hardcoded_ids');
include_once('data_export/DTOGenerators.php');
include_once('data_export/postRequest.php');
include_once('data_export/getAuthenticationToken.php');
include_once('data_export/handleApiViolations.php');
include_once('mysql_class_qc.php');


const ADRESS_END_POINT = "http://sdsdb_nginx_1/api/addresses";
const PERSON_END_POINT = "http://sdsdb_nginx_1/api/people";
const EMPLOYEE_END_POINT = "http://sdsdb_nginx_1/api/employees";
const PERSON_ADDRESS_ENDPOINT = "http://sdsdb_nginx_1/api/person_addresses";
const PERSON_QUALIFICATION_ENDPOINT = "http://sdsdb_nginx_1/api/person_qualifications";
const EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT = "http://sdsdb_nginx_1/api/employee_task_category_salaries";
const PHONE_NUMBER_ENDPOINT = "http://sdsdb_nginx_1/api/phone_numbers";
const PERSON_PHONE_NUMBER_ENDPOINT = "http://sdsdb_nginx_1/api/person_phone_numbers";
const NOTES_ENDPOINT = "http://sdsdb_nginx_1/api/employee_notes";
const STATUS_IRI_BASE = "/api/employee_statuses/";
const QUALIFICATION_IRI_BASE = "/api/qualifications/";
const USERS_ENDPOINT=  "http://sdsdb_nginx_1/api/users";
const COMPANY_USERS_ENDPOINT=  "http://sdsdb_nginx_1/api/users";


const BUREAU_TASK_CATEGORY_NAME_IRI = "api/task_categories/1";
const SAUVETEUR_TASK_CATEGORY_NAME_IRI ="api/task_categories/2";
const ASSISTANT_TASK_CATEGORY_NAME_IRI = "api/task_categories/3";

const TELEPHONE_MAISON_IRI = "api/person_phone_number_types/1";
const TELEPHONE_CELLULAIRE_IRI = "api/person_phone_number_types/2";

const SDS_QC_IRI = "api/companies/1";

use \ForceUTF8\Encoding;

$classSql = new SQLClass();
$get_employees_query = "SELECT * FROM employe ORDER BY IDEmploye ";
$classSql2 = new SQLClass();
$classSql->Select($get_employees_query);
$authorization_header = getAuthenticationToken();

$errors = array();
$violations = array();
$nbUserDoneSinceLastTokenRetrieval = 0;
while($cursorEmployee =  $classSql->FetchAssoc())
{
    if($nbUserDoneSinceLastTokenRetrieval>500)
    {
        $nbUserDoneSinceLastTokenRetrieval = 0;
        $authorization_header = getAuthenticationToken();
        print("renewing token");
    }else{
        $nbUserDoneSinceLastTokenRetrieval++;
    }

    $employeeIdFromSDSDB = $cursorEmployee['IDEmploye'];

    #Address
    $adresseDTO = getAddressDTO($cursorEmployee, $secteurIdConversion, $errors);
    $response = postRequest(ADRESS_END_POINT, $authorization_header, $adresseDTO);
    $addressEntity = json_decode($response,True);
    extractViolationFromResponse($violations,ADRESS_END_POINT, $employeeIdFromSDSDB, $addressEntity);

    #Person
    $personDTO = getPersonDTO($cursorEmployee, $errors);
    $response = postRequest(PERSON_END_POINT, $authorization_header, $personDTO);
    $personEntity = json_decode($response,True);
    extractViolationFromResponse($violations,PERSON_END_POINT, $employeeIdFromSDSDB, $personEntity);

    #User
    if($cursorEmployee["Status"]=="Bureau"){
        $role = 'ROLE_ADMIN';
    }else{
        $role = 'ROLE_USER';
    }
    $userDTO = array(
        'email'=>$personEntity["email"],
        'roles'=>[$role],
        'plainPassword'=> substr($personDTO['nas'],-3),
        'person'=>$personEntity["@id"],
        'companies'=>[SDS_QC_IRI]);
    $response = postRequest(USERS_ENDPOINT, $authorization_header, $userDTO);

    extractViolationFromResponse($violations,USERS_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));



    #PersonAddress
    $response = postRequest(PERSON_ADDRESS_ENDPOINT, $authorization_header,array('person'=>$personEntity['@id'], 'address'=>$addressEntity['@id'],'name'=>'Principale') );


    #PhoneNumber
    $maisonPhoneNumber = null;

    if($cursorEmployee['TelP']<>"")
    {
        $maisonPhoneNumber = $cursorEmployee['TelP'];
    }else if($cursorEmployee['TelA']<>""){
        $maisonPhoneNumber = $cursorEmployee['TelA'];
    }
    if(!is_null($maisonPhoneNumber))
    {
        $response = postRequest(PHONE_NUMBER_ENDPOINT, $authorization_header,array('number'=>$maisonPhoneNumber) );
        $homephoneNumberEntity = json_decode($response, true);

        $response = postRequest(PERSON_PHONE_NUMBER_ENDPOINT, $authorization_header,array('person'=>$personEntity['@id'], 'phoneNumber'=>$homephoneNumberEntity['@id'],'personPhoneNumberType'=>TELEPHONE_MAISON_IRI) );
        extractViolationFromResponse($violations,PERSON_PHONE_NUMBER_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));
    }

    if($cursorEmployee['Cell']<>""){
        $response = postRequest(PHONE_NUMBER_ENDPOINT, $authorization_header,array('number'=>$cursorEmployee['Cell']) );
        $cellphoneNumberEntity = json_decode($response, true);

        $response = postRequest(PERSON_PHONE_NUMBER_ENDPOINT, $authorization_header,array('person'=>$personEntity['@id'], 'phoneNumber'=>$cellphoneNumberEntity['@id'],'personPhoneNumberType'=>TELEPHONE_CELLULAIRE_IRI) );
        extractViolationFromResponse($violations,PERSON_PHONE_NUMBER_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));
    }


    #Employee
    $employeeDTO = getEmployeDTO($cursorEmployee,$personEntity['@id'], SDS_QC_IRI, $errors);
    $response = postRequest(EMPLOYEE_END_POINT, $authorization_header,$employeeDTO );
    $employeeEntity = json_decode($response, True);
    extractViolationFromResponse($violations,EMPLOYEE_END_POINT, $employeeIdFromSDSDB, $employeeEntity);

    #Salaires
    $response = postRequest(EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT, $authorization_header,array('employee'=>$employeeEntity["@id"], 'taskCategory'=>BUREAU_TASK_CATEGORY_NAME_IRI, 'salary'=>$cursorEmployee['SalaireB']) );
    extractViolationFromResponse($violations,EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));
    $response = postRequest(EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT, $authorization_header,array('employee'=>$employeeEntity["@id"], 'taskCategory'=>SAUVETEUR_TASK_CATEGORY_NAME_IRI, 'salary'=>$cursorEmployee['SalaireS']) );
    extractViolationFromResponse($violations,EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));
    $response = postRequest(EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT, $authorization_header,array('employee'=>$employeeEntity["@id"], 'taskCategory'=>ASSISTANT_TASK_CATEGORY_NAME_IRI, 'salary'=>$cursorEmployee['SalaireA']) );
    extractViolationFromResponse($violations,EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));

    #Notes
    if($cursorEmployee['Notes']<>"")
    {
        $safeNote =  ForceUTF8\Encoding::toUTF8($cursorEmployee['Notes']);
        $response = postRequest(NOTES_ENDPOINT,  $authorization_header,array('employee'=>$employeeEntity["@id"], 'note'=>$safeNote));
        extractViolationFromResponse($violations,NOTES_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));
    }

    #Qualifications
    $qualificationQuery = "SELECT * FROM link_employe_qualification WHERE IDEmploye = ".$cursorEmployee['IDEmploye'];
    $classSql2->Select($qualificationQuery);
    while($cursorQualification = $classSql2->FetchAssoc())
    {
        $qualificationIRI = QUALIFICATION_IRI_BASE.$cursorQualification["IDQualification"];
        $qualificationDTO = getQualificationDTO($cursorQualification, $personEntity["@id"], $qualificationIRI);

        $response = postRequest(PERSON_QUALIFICATION_ENDPOINT, $authorization_header, $qualificationDTO);
        extractViolationFromResponse($violations,NOTES_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));
    }

    print($employeeIdFromSDSDB." : Done \n");

}
print_r($violations);
print_r($errors);