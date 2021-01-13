<?php

namespace employee;

interface EmployeeDataSourceInterface
{
    public function getEmployeeSelectList($company, $datetime=null);
    public function getViewEmployeeListURI();
    public function getViewEmployeeURI($IDEmploye);
    public function getEmployees($company, $datetime=null);
}
