<?php
/**
 * Created by PhpStorm.
 * User: jtbai
 * Date: 04/07/18
 * Time: 8:24 AM
 */

include_once ('app/employee.php');

class TestEmploye extends PHPUnit_Framework_TestCase
{

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

//
//    function test_GivenFactureDatingFromCurrentWeek_whenAddingShift_thenAddedShiftHasNotJourShifted(){
//        $bills_by_cote = $this->customer->calculate_facture_by_cote();
//
//    }
}