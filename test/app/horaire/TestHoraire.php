<?php

include_once ('app/horaire/horaire.php');
include_once ('helper/TimeService.php');
include_once ('mysql_class_test.php');
include_once ('app/shift.php');
include_once ('app/employee.php');

class TestHoraire extends PHPUnit_Framework_TestCase{

    const A_SHIFT_ID = 1337;

    /**
     * @before
     */
    function setup_tested_instance(){
        $time_service =new TimeService();
        $this->horaire = new Horaire($time_service , new SqlClass());
        $this->horaire->add_shift(new Shift(self::A_SHIFT_ID, $time_service ));
    }

    function test_givenEmployeeList_whenGetFreeEmployee_returnNonWorkingEmployees(){
        $AN_EMPLOYEE_LIST = array(new Employee(2), new Employee(90));
        $free_employees = $this->horaire->get_free_employees($AN_EMPLOYEE_LIST);

        $this->assertEquals(1, sizeof($free_employees));
    }
}
