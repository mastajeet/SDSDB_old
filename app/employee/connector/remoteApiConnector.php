<?php
namespace employee;
include_once('app/employee/connector/EmployeeDataSourceInterface.php');
class remoteApiConnector implements EmployeeDataSourceInterface
{
    private $baseApiURL = "http://sdsdb_nginx_1/api";

    public function __construct()
    {
        $this->authenticationHeader = $this->getAuthenticationHeader();
    }

    public function getEmployeeSelectList($company, $datetime = null)
    {
        $employees = $this->getEmployees($company, $datetime);
        $employee_list = $this->buildEmployeeList($employees);

        return ($employee_list);
    }

    public function getEmployees($company, $datetime = null)
    {
        $uri = $this->baseApiURL."/employees?pagination=false&isTerminated=false&company=".$company;
        $employees = $this->getObjectsFromApi($uri,  $this->authenticationHeader);

        return $employees;
    }

    public function getViewEmployeeURI($IDEmploye)
    {
        return "http://127.0.0.1/employes";
    }

    private function buildEmployeeList(Array $objectList)
    {
        $employee_list = [];

        foreach($objectList as $employee)
        {
            $qualifications = "";
            foreach($employee['qualifications'] as $qualification)
            {
                $qualifications. " ".$qualification['qualification']['abbreviation'];
            }
            $employee_list[$employee['number']] = $employee['lastName'] . " " . $employee['firstName'] . " [" . $qualifications . "]";
        }


        return $employee_list;
    }

    static public function getAuthenticationHeader()
    {
        print("AuthCalled");
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

    static public function getObjectsFromApi($uri, $autheticationHeader)
    {
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $autheticationHeader));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $objects = json_decode($result, true)['hydra:member'];
        return($objects);
    }
}
