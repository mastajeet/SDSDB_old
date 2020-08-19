<?php

function getAuthenticationToken()
{
    $url = 'http://sdsdb_nginx_1/authentication_token';
    $ch = curl_init($url);
    $data = array(
        'email' => 'jtbai@admin.com',
        'password' => 'lolk1234'
    );
    $payload = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $response_body = json_decode($result, True);

    $token = $response_body['token'];
    $authentication_header = "Authorization:Bearer " . $token;

    return $authentication_header;
}