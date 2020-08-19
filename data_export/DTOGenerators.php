<?php
/**
 * @param array $cursor
 * @param array $secteur_id_conversion
 * @return array
 */

USE ForceUTF8\Encoding;

function getAddressDTO(array $cursor, $secteur_id_conversion, &$errors)
{

    $adress_entity_dto = [];
    $no_employe = $cursor['IDEmploye'];
    if (trim($cursor['IDSecteur']) <> "") # Dans la bd on a que le null est une string avec une ou deux ou 0 espaces.
    {
        $sdsdb_sector_id = $cursor['IDSecteur'];
        $district_id = $secteur_id_conversion[$sdsdb_sector_id];
        $district_uri = "/api/districts/".$district_id;

        $adress_entity_dto['district'] = $district_uri;
    } else {
        $district_uri = null;
        $errors[] = "ADDRESS - employe " . $no_employe . " doesn't have disctrict values";
    }

    $is_quebec = preg_match_all(QUEBEC_CITY_REGEX, $cursor['Ville']);
    $is_mtl = preg_match_all(MONTREAL_CITY_REGEX, $cursor['Ville']);
    $is_tr =  preg_match_all(TR_CITY_REGEX, $cursor['Ville']);
    if($is_quebec){
        $city_id = QUEBEC_CITY;
    }elseif ($is_mtl){
        $city_id = MONTREAL_CITY;
    }elseif ($is_tr){
        $city_id = TROIS_RIVIERE_CITY;
    }else{ #Par defaut mon met Québec, et on sort la liste des modifications à faire par après? Ou on y va avec une edit distances avec des nom cleanés?
        $city_id = QUEBEC_CITY;
        $errors[] = "ADDRESS - Employe " . $no_employe . " doesn't have a valid city";
    }

    $province_id = QUEBEC_PROVINCE;
    $address = $cursor['Adresse'];

    $is_valid_postal_code = preg_match_all(POSTAL_CODE_REGEX, $cursor['CodePostal'], $valid_postal_code);
    if ($is_valid_postal_code) {
        $zipcode = $valid_postal_code[0][0]; #Le premier group du match all
        $zipcode = strtoupper($zipcode);
        $adress_entity_dto['postalCode'] = $zipcode;
    } else {
        $zipcode = null;
//        $adress_entity_dto['postalCode'] = null;
        $errors[] = "ADDRESS - Employe " . $no_employe . " doesn't have a valid postal code";
    }

    $adress_entity_dto['city'] = "/api/cities/".$city_id;
    $adress_entity_dto['province'] = "/api/provinces/".$province_id;
    $adress_entity_dto['street'] = Encoding::toUTF8($address);


    return $adress_entity_dto;
}


function getPersonDTO(array $cursor, &$errors)
{

    $employeeDTO = array();
    $employeeDTO['firstName'] = Encoding::toUTF8($cursor['Prenom']) ;
    $employeeDTO['lastName'] = Encoding::toUTF8($cursor['Nom']);
    if($cursor['HName']<>""){
        $employeeDTO['nickname'] = Encoding::toUTF8($cursor['HName']);
    }
    $employeeDTO['nas'] =  $cursor['NAS'];
    $dateOfBirthTimeStamp =$cursor['DateNaissance'];
    $employeeDTO['dateOfBirth'] = date("c", $dateOfBirthTimeStamp);
    if ($cursor['Email'] <> "")
    {
        $employeeDTO['email'] = $cursor['Email'];
    }else{
        $employeeDTO['email'] =  $cursor['Nom']."@".$cursor['Prenom'].".".$cursor['IDEmploye'];
        $errors[] = "PERSON - Employe " . $cursor['IDEmploye'] . " doesn't have a valid email";
    }

    return $employeeDTO;
}

function getEmployeDTO(array $cursor, $PersonIRI, $statusIRI, $companyIRI,  &$errors)
{
    $employeeDTO = array();
    $employeeDTO['number'] = $cursor["IDEmploye"];
    $employeeDTO['status'] = $statusIRI;
    $employeeDTO['person'] = $PersonIRI;
    $employeeDTO['company'] = $companyIRI;
    $employeeDTO['isTerminated'] = $cursor["Cessation"]==1 ? True : False;
    $employeeDTO['motiveOfTermination'] = $cursor["Raison"];
    $employeeDTO['hiringDate'] = date("c", $cursor['DateEmbauche']);
    $employeeDTA['status'] = "";
    return $employeeDTO;
}

function getEmployeeStatusId($cursor, &$errors)
{
    /*
   1 | Temps plein |
    2 | Secondaire  |
    3 | C�GEP       |
    4 | Universit�  |
    5 | Bureau      |
    */

    $isFullTime = preg_match_all(FULL_TIME_REGEX, $cursor['Status']);
    $isSecondaire = preg_match_all(SECONDAIRE_REGEX, $cursor['Status']);
    $isCEGEP =  preg_match_all(CEGEP_REGEX, $cursor['Status']);
    $isUniversite =  preg_match_all(UNIVERSITY_REGEX, $cursor['Status']);
    $isBureau =  preg_match_all(BUREAU_REGEX, $cursor['Status']);

    if($isFullTime)
    {
        $statusId = "1";
    }else if($isSecondaire)  {
        $statusId = "2";
    }else if($isCEGEP) {
        $statusId = "3";
    }else if($isUniversite){
        $statusId = "4";
    }else if($isBureau){
        $statusId = "5";
    }else{
        $errors[] = "STATUS - Employe ". $cursor['IDEmploye'] ." doesn't have a working status";
    }

    return $statusId;
}


/**
 * @param array $cursorQualification
 * @param $qualificationIRI
 * @return array
 */
function getQualificationDTO(array $cursorQualification, $personIRI, $qualificationIRI)
{
    $qualificationDTO = array('qualification' => $qualificationIRI, 'person' => $personIRI);
    $qualificationDTO['expiration'] = date("c", $cursorQualification['Expiration']);

    return $qualificationDTO;
}
