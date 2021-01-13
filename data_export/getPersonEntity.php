<?php

function getPersonEntity($cursor, $authorization_header){
    $personEntity = null;

    if(filter_var($cursor['Email'], FILTER_VALIDATE_EMAIL))
    {

        $url = "http://prod.qcnat.o2web.ws/api/people?email=".urlencode($cursor['Email']);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $authorization_header));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $personResponse = json_decode($result, true)['hydra:member'];
        if(array_count_values($personResponse)>0){
            $personEntity =$personResponse[0];
        }
    }

    return($personEntity);
}
