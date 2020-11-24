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
include_once('mysql_class_tr.php');

//const ADRESS_END_POINT = "http://sdsdb_nginx_1/api/addresses";
//const PERSON_END_POINT = "http://sdsdb_nginx_1/api/people";
//const EMPLOYEE_END_POINT = "http://sdsdb_nginx_1/api/employees";
//const PERSON_ADDRESS_ENDPOINT = "http://sdsdb_nginx_1/api/person_addresses";
//const PERSON_QUALIFICATION_ENDPOINT = "http://sdsdb_nginx_1/api/person_qualifications";
//const EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT = "http://sdsdb_nginx_1/api/employee_task_category_salaries";
//const PHONE_NUMBER_ENDPOINT = "http://sdsdb_nginx_1/api/phone_numbers";
//const PERSON_PHONE_NUMBER_ENDPOINT = "http://sdsdb_nginx_1/api/person_phone_numbers";
//const NOTES_ENDPOINT = "http://sdsdb_nginx_1/api/employee_notes";
//const STATUS_IRI_BASE = "/api/employee_statuses/";
//const QUALIFICATION_IRI_BASE = "/api/qualifications/";
//const USERS_ENDPOINT=  "http://sdsdb_nginx_1/api/users";
//const COMPANY_USERS_ENDPOINT=  "http://sdsdb_nginx_1/api/users";


const ADRESS_END_POINT = "http://prod.qcnat.o2web.ws/api/addresses";
const PERSON_END_POINT = "http://prod.qcnat.o2web.ws/api/people";
const EMPLOYEE_END_POINT = "http://prod.qcnat.o2web.ws/api/employees";
const PERSON_ADDRESS_ENDPOINT = "http://prod.qcnat.o2web.ws/api/person_addresses";
const PERSON_QUALIFICATION_ENDPOINT = "http://prod.qcnat.o2web.ws/api/person_qualifications";
const EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT = "http://prod.qcnat.o2web.ws/api/employee_task_category_salaries";
const PHONE_NUMBER_ENDPOINT = "http://prod.qcnat.o2web.ws/api/phone_numbers";
const PERSON_PHONE_NUMBER_ENDPOINT = "http://prod.qcnat.o2web.ws/api/person_phone_numbers";
const NOTES_ENDPOINT = "http://prod.qcnat.o2web.ws/api/employee_notes";
const STATUS_IRI_BASE = "/api/employee_statuses/";
const QUALIFICATION_IRI_BASE = "/api/qualifications/";
const USERS_ENDPOINT=  "http://prod.qcnat.o2web.ws/api/users";
const COMPANY_USERS_ENDPOINT=  "http://prod.qcnat.o2web.ws/api/users";


const BUREAU_TASK_CATEGORY_NAME_IRI = "api/task_categories/1";
const SAUVETEUR_TASK_CATEGORY_NAME_IRI ="api/task_categories/2";
const ASSISTANT_TASK_CATEGORY_NAME_IRI = "api/task_categories/3";

const TELEPHONE_MAISON_IRI = "api/person_phone_number_types/1";
const TELEPHONE_CELLULAIRE_IRI = "api/person_phone_number_types/2";

const SDS_QC_IRI = "api/companies/3";

use \ForceUTF8\Encoding;

$classSql = new SQLClass();
$get_employees_query = "SELECT * FROM employe ORDER BY IDEmploye ";
$classSql2 = new SQLClass();
$classSql->Select($get_employees_query);
$authorization_header = getAuthenticationToken();
print_r($authorization_header);

# Error : 617 noemie potras
# 620 lenie bergeron
# 659 frederic bernier
# 754 Marie-Pier Gaudreault
# 820 Émilie Bergeron
# 989
# 1077
# 1633
# 1704
# 1714
# 1715
# 2026
# 2222
# Sandra dubord
# Isabelle Lavoie
# Rebecca Rochette
## en double dams sds
# !in_array($employeeIdFromSDSDB, [617,620, 659, 754, 820, 989, 1077,1208, 1386, 1516, 1586,1633, 1704, 1714, 1715, 2026])
#

//$SDSMTL_2 = [38,61,62,63,64,65,66,67,68,69,70,81,87,98,100,103,107,118,125,145,157,161,168,171,179,186,192,195,196,199,204,230,243,245,246,247,248,281,293,306,337,341,350,353,362,366,401,407,416,422,462,477,480,483,490,497,552,554,555];
//in_array($employeeIdFromSDSDB, $SDSMTL_2)
$errors = array();
$violations = array();
$nbUserDoneSinceLastTokenRetrieval = 0;
print(" \n");
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

//    if($employeeIdFromSDSDB>477 and $employeeIdFromSDSDB<28200) {
    if($employeeIdFromSDSDB>30) {
        print("trying".$employeeIdFromSDSDB." \n");
        $personEntity = getPersonEntity($cursorEmployee, $authorization_header);
        if(is_null($personEntity)) {
            #Person
            $personDTO = getPersonDTO($cursorEmployee, $errors);
            $response = postRequest(PERSON_END_POINT, $authorization_header, $personDTO);
            $personEntity = json_decode($response, True);
            extractViolationFromResponse($violations, PERSON_END_POINT, $employeeIdFromSDSDB, $personEntity);

            #Address
            $adresseDTO = getAddressDTO($cursorEmployee, $secteurIdConversion, $errors);
            $response = postRequest(ADRESS_END_POINT, $authorization_header, $adresseDTO);
            $addressEntity = json_decode($response, True);
            extractViolationFromResponse($violations, ADRESS_END_POINT, $employeeIdFromSDSDB, $addressEntity);


            #User
            if ($cursorEmployee["Status"] == "Bureau") {
                $role = 'ROLE_ADMIN';
            } else {
                $role = 'ROLE_USER';
            }
            $plain_password = $personDTO['nas'] <> "" ? substr($personDTO['nas'], -3) : "000";

            $userDTO = array(
                'email' => $personEntity["email"],
                'roles' => [$role],
                'plainPassword' => $plain_password,
                'person' => $personEntity["@id"],
                'companies' => [SDS_QC_IRI]);
            $response = postRequest(USERS_ENDPOINT, $authorization_header, $userDTO);

            extractViolationFromResponse($violations, USERS_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));


            #PersonAddress
            $response = postRequest(PERSON_ADDRESS_ENDPOINT, $authorization_header, array('person' => $personEntity['@id'], 'address' => $addressEntity['@id'], 'name' => 'Principale'));


            #PhoneNumber
            $maisonPhoneNumber = null;

            if ($cursorEmployee['TelP'] <> "" and $cursorEmployee['TelP'] <> "418" and strlen($cursorEmployee['TelP']) == 10) {
                $maisonPhoneNumber = $cursorEmployee['TelP'];
            } else if ($cursorEmployee['TelA'] <> "" and $cursorEmployee['TelA'] <> "418" and strlen($cursorEmployee['TelA']) == 10) {
                $maisonPhoneNumber = $cursorEmployee['TelA'];
            }
            if (!is_null($maisonPhoneNumber)) {
                $response = postRequest(PHONE_NUMBER_ENDPOINT, $authorization_header, array('number' => $maisonPhoneNumber));
                $homephoneNumberEntity = json_decode($response, true);

                $response = postRequest(PERSON_PHONE_NUMBER_ENDPOINT, $authorization_header, array('person' => $personEntity['@id'], 'phoneNumber' => $homephoneNumberEntity['@id'], 'personPhoneNumberType' => TELEPHONE_MAISON_IRI));
                extractViolationFromResponse($violations, PERSON_PHONE_NUMBER_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));
            }

            if ($cursorEmployee['Cell'] <> "" and $cursorEmployee['Cell'] <> "418" and strlen($cursorEmployee['Cell']) == 10) {
                $response = postRequest(PHONE_NUMBER_ENDPOINT, $authorization_header, array('number' => $cursorEmployee['Cell']));
                $cellphoneNumberEntity = json_decode($response, true);

                $response = postRequest(PERSON_PHONE_NUMBER_ENDPOINT, $authorization_header, array('person' => $personEntity['@id'], 'phoneNumber' => $cellphoneNumberEntity['@id'], 'personPhoneNumberType' => TELEPHONE_CELLULAIRE_IRI));
                extractViolationFromResponse($violations, PERSON_PHONE_NUMBER_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));
            }


            #Qualifications
            $qualificationQuery = "SELECT * FROM link_employe_qualification WHERE IDEmploye = " . $cursorEmployee['IDEmploye'];
            $classSql2->Select($qualificationQuery);
            while ($cursorQualification = $classSql2->FetchAssoc()) {
                $qualificationIRI = QUALIFICATION_IRI_BASE . $cursorQualification["IDQualification"];
                $qualificationDTO = getQualificationDTO($cursorQualification, $personEntity["@id"], $qualificationIRI);

                $response = postRequest(PERSON_QUALIFICATION_ENDPOINT, $authorization_header, $qualificationDTO);
                extractViolationFromResponse($violations, NOTES_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));
            }

        }

        #Employee
        $employeeDTO = getEmployeDTO($cursorEmployee, $personEntity['@id'], SDS_QC_IRI, $errors);
//        print($employeeDTO);
        $response = postRequest(EMPLOYEE_END_POINT, $authorization_header, $employeeDTO);
//        print($response);
//        die();
        $employeeEntity = json_decode($response, True);
        extractViolationFromResponse($violations, EMPLOYEE_END_POINT, $employeeIdFromSDSDB, $employeeEntity);

        #Salaires
        $response = postRequest(EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT, $authorization_header, array('employee' => $employeeEntity["@id"], 'taskCategory' => BUREAU_TASK_CATEGORY_NAME_IRI, 'salary' => $cursorEmployee['SalaireB']));
        extractViolationFromResponse($violations, EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));
        $response = postRequest(EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT, $authorization_header, array('employee' => $employeeEntity["@id"], 'taskCategory' => SAUVETEUR_TASK_CATEGORY_NAME_IRI, 'salary' => $cursorEmployee['SalaireS']));
        extractViolationFromResponse($violations, EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));
        $response = postRequest(EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT, $authorization_header, array('employee' => $employeeEntity["@id"], 'taskCategory' => ASSISTANT_TASK_CATEGORY_NAME_IRI, 'salary' => $cursorEmployee['SalaireA']));
        extractViolationFromResponse($violations, EMPLOYEE_TASK_CATEGORY_SALARY_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));

        #Notes
        if ($cursorEmployee['Notes'] <> "") {
            $safeNote = ForceUTF8\Encoding::toUTF8($cursorEmployee['Notes']);
            $response = postRequest(NOTES_ENDPOINT, $authorization_header, array('employee' => $employeeEntity["@id"], 'note' => $safeNote));
            extractViolationFromResponse($violations, NOTES_ENDPOINT, $employeeIdFromSDSDB, json_decode($response, true));
        }


        print($employeeIdFromSDSDB." : Done \n");
    }

}
print_r($violations);
print_r($errors);