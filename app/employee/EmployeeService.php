<?php
namespace employee;

class EmployeeService
{
    private $currentSession;
    private $companyId;

    function __construct($companyId, $current_session, EmployeeDataSourceInterface $dataSource)
    {
        $this->companyId =$companyId;
        $this->dataSource = $dataSource;
        $this->currentSession = $current_session;
    }

    function getEmployeSelectList($datetime=null)
    {
        $employeeList = $this->dataSource->getEmployeeSelectList($this->companyId, $datetime=null);
        $latin1EmployeeList = array();
        foreach($employeeList as $id=>$name){
            $latin1EmployeeList[$id] = \ForceUTF8\Encoding::toLatin1($name);
        }

        return $latin1EmployeeList;
    }

    function getEmployees($datetime=null)
    {
        return $this->dataSource->getEmployees($this->companyId, $datetime=null);
    }

    public function getViewEmployeeURI($IDEmploye){
        return $this->dataSource->getViewEmployeeURI($IDEmploye);
    }

    public function getViewEmployeeListURI(){
        return $this->dataSource->getViewEmployeeListURI();
    }

    public function getEmployeesSalaries(){
        return $this->dataSource->getEmployeesSalaries($this->companyId);
    }
}