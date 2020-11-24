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
        return $this->dataSource->getEmployeeSelectList($this->companyId, $datetime=null);
    }

    function getEmployees($datetime=null)
    {
        return $this->dataSource->getEmployees($this->companyId, $datetime=null);
    }

    public function getViewEmployeeURI($IDEmploye){
        return $this->dataSource->getViewEmployeeURI($IDEmploye);
    }

    public function getEmployeesSalaries(){
        return $this->dataSource->getEmployeesSalaries($this->companyId);
    }
}