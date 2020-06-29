<?php
require_once('view/employee/CSVEmployeeSummaryListRenderer.php');

class TestEmployeeListRenderer extends PHPUnit_Framework_TestCase
{

    private $employee_dto;

    /**
     * @before
     */
    function setUpEmployeeDTOList()
    {
        $this->employee_dto = Array();
        $this->employee_dto[1] = Array("nom"=>"nom_1","prenom"=>"prenom_1","cellphone_number"=>"4189999999");
        $this->employee_dto[2] = Array("nom"=>"nom_2","prenom"=>"prenom_2","cellphone_number"=>"5186666666");
    }

    function test_givenListOfTwoEmployeesDTO_whenRenderCSVListEmployeeSummary_thenObtainCSVString()
    {
        $csv_string = RenderCSVListEmployeeSummary($this->employee_dto);

        $this->assertEquals($this->getCSVString(),$csv_string);
    }

    private function getCSVString()
    {
        return 'nom,prenom,telephone
nom_1,prenom_1,(418) 999-9999
nom_2,prenom_2,(518) 666-6666
';
    }
}
