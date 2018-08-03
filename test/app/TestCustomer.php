<?php
/**
 * Created by PhpStorm.
 * User: jtbai
 * Date: 04/07/18
 * Time: 8:24 AM
 */

include_once ('app/customer.php');

class TestCustomer extends PHPUnit_Framework_TestCase
{

    /**
     * @before
     */
    function setup_tested_instance(){
        $this->customer = new Customer(17);
    }

    function test_givenCustomerWithFacture_whenCalculateBillsByCote_getSumOfAllBillsByCote(){
//        $bills_by_cote = $this->customer->calculate_facture_by_cote();


    }
}