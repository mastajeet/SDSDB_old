<?php
include_once ('mysql_class_test.php');
include_once ('app/BaseModel.php');
include_once ('app/employee.php');

class TestEmploye extends PHPUnit_Framework_TestCase
{

    const E_11 = "E11";

    function test_GivenEmployeeWithNoDashe_whenInitial_thenGetNameAndLastNameFirstLetter(){
        $employee = new Employee(2); #Julie Fortin

        $employee_initials = $employee->initials();
        $expected_employee_initials = "JF";

        $this->assertEquals($expected_employee_initials, $employee_initials );
    }

    function test_GivenEmployeeWithDashe_whenInitial_thenGetNameSecondeNameAndLastNameFirstLetter(){
        $employee = new Employee(90); #Jean-Thomas Baillargeon

        $employee_initials = $employee->initials();
        $expected_employee_initials = "JTB";

        $this->assertEquals($expected_employee_initials, $employee_initials );
    }

    function test_GivenSession_whenGetEmployeeForSession_thenReturnAllEmployeeForThatSession(){
        $employee_list = Employee::get_employee_list_for_session(self::E_11);
        $this->assertEquals(2, sizeof($employee_list));
    }

    //
//    function test_GivenFactureDatingFromCurrentWeek_whenAddingShift_thenAddedShiftHasNotJourShifted(){
//        $bills_by_cote = $this->customer->calculate_facture_by_cote();
//
//    }
}