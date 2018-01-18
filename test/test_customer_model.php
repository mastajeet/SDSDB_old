<?php

require_once('../app/inspection.php');
require_once('../mysql_class_qc.php');

class TestCustomerModel extends PHPUnit_Framework_TestCase
{
    function test_constructor()
    {
        $customer = new customer();
        $this->assertEquals($customer->IDClient, 44);
        $this->assertEquals($customer->Ferie, 1.5);
    }

}