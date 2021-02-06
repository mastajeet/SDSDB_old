<?php

include_once('app/employee/connector/remoteApiConnector.php');
include_once('forceutf8/Encoding.php');

class Employee
{

    private $baseApiURL = "http://prod.qcnat.o2web.ws/api/";
//    private $baseApiURL = "http://sdsdb_nginx_1/api/";
    private static $authenticationHeader = null;
    private static $employeeList = null;
    private static $listeDesSalaires = null;
    public $IDEmploye;
    public $Prenom;
    public $Nom;
    public $HName;
    private $SalaireA;
    private $SalaireS;
    private $SalaireB;
    public $NAS;
    public $TelP;
    public $Cell;
    private $vacations;

    public function __construct($IDEmploye)
    {
        if(is_null(Employee::$employeeList))
        {
            $employeeSerivce = new employee\EmployeeService($_COOKIE['companyId'],null, new \employee\remoteApiConnector());
            Employee::$employeeList = array();
            $startTime = new DateTime();
            $employees =  $employeeSerivce->getEmployees() ;
            $requestTime = new DateTime();
            foreach($employees as $employee)
            {
                Employee::$employeeList[$employee['number']] = $employee;
            }
            $tableTime = new DateTime();
            $request = $requestTime->getTimestamp() - $startTime->getTimestamp();
            $tabling = $tableTime->getTimestamp() - $requestTime->getTimestamp() ;
//            print_r($request);
//            print_r($tabling);
        }

        if(!$this->isNullEmploye($IDEmploye))
        {
            if(key_exists($IDEmploye,Employee::$employeeList)){
                $this->employee = Employee::$employeeList[$IDEmploye];
            }else{
                print("l'employé ".$IDEmploye." n'existe pas");
                $this->employee = $this->getNullEmployeeValues();
            }

            $this->IDEmploye = $this->employee['number'];
            $this->Prenom = $this->employee['first_name'];
            $this->Nom = $this->employee['last_name'];
            $this->HName = $this->employee['nickname'];
        }else{
            $this->employee = $this->getNullEmployeeValues();

        }
    }


    function __get($name)
    {
        if(in_array($name,["SalaireA","SalaireS","SalaireB"]))
        {
            if(is_null(Employee::$listeDesSalaires))
            {
                $employeeSerivce = new employee\EmployeeService($_COOKIE['companyId'],null, new \employee\remoteApiConnector());
                $salaires = $employeeSerivce->getEmployeesSalaries();
                Employee::$listeDesSalaires = array();
                foreach($salaires as $salaire)
                {
                    if(!in_array($salaire['number'], array_keys(Employee::$listeDesSalaires))){
                        Employee::$listeDesSalaires[$salaire['number']] = array();
                    }
                    Employee::$listeDesSalaires[$salaire['number']][$salaire['name']] = $salaire['salary'];
                }

            }
            $this->salaires = Employee::$listeDesSalaires[$this->IDEmploye];
            switch($name){
                CASE "SalaireA":
                    return isset($this->salaires["Assistant"]) ? $this->salaires["Assistant"] : 0;

                CASE "SalaireB":
                    return  isset($this->salaires["Bureau"]) ? $this->salaires["Bureau"] : 0;

                CASE "SalaireS":
                    return  isset($this->salaires["Sauveteur"]) ? $this->salaires["Sauveteur"] : 0;
            }

        }
        return $this->$name;
    }

    public function isInVacation($datetime_object)
    {
        return false;
    }

    public function getHoraireName()
    {
        if (isset($this->HName) and $this->HName <> "") {
            return $this->HName;
        } else {
            $person = $this->employee;
            $nomHoraire = $this->Prenom . "&nbsp;" . $this->Nom;
            $nomHoraire = \ForceUTF8\Encoding::toLatin1($nomHoraire);
            return substr($nomHoraire, 0, 20);
        }
    }

    public function initials(){
        $Initiales = "";

        foreach(explode('-',$this->Prenom) as $v){
            $Initiales .= substr($v,0,1);
        }

        foreach(explode('-',$this->Nom) as $v){
            $Initiales .= substr($v,0,1);
        }

        return $Initiales;
    }

    function isNullEmploye($Arg=null)
    {
        if(is_null($Arg) and $this->IDEmploye==0)
        {
            return true;
        }
        if(is_numeric($Arg) and $Arg==0)
        {
            return true;
        }
        return false;
    }

    private function getNullEmployeeValues()
    {
        return array(
            'IDEmploye'=>0,
            'Prenom'=>'',
            'Nom'=>'',
            'HName'=>null);
    }
}