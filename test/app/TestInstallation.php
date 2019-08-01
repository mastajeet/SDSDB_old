<?php

require_once('app/installation.php');
require_once('mysql_class_test.php');

class TestInstallation extends PHPUnit_Framework_TestCase
{

    private $A_CUSTOMER_COTE_WITH_3_INSTALLATION_3_COTES = "TI";
    private $A_CUSTOMER_COTE_WITH_3_INSTALLATION_2_COTES = "TI1";
    private $A_YEAR = 2019;

    function test_constructeur(){
        $Installation = new Installation(1);
        $this->assertEquals($Installation->Cote,'QI');
    }

    function test_constructeur_2(){
        try{
            $Installation = new Installation(-5);
            $this->assertEquals(1,-1);
        }
        catch(Exception $e) {
            $this->assertEquals(1,1);
        }
    }

    function test_givenCustomerWith3InstallationWithDifferentCote_whenGetInstallerByCustomerCote_thenReturn3Installations(){
        $Installations = Installation::get_installation_by_customer_cote($this->A_CUSTOMER_COTE_WITH_3_INSTALLATION_3_COTES);
        $this->assertEquals(3, count($Installations));
    }

    function test_givenCustomerWith3Installation2WithSameCote_whenGetInstallerByCustomerCote_thenReturn3Installations(){
        $Installations = Installation::get_installation_by_customer_cote($this->A_CUSTOMER_COTE_WITH_3_INSTALLATION_2_COTES);
        $this->assertEquals(3, count($Installations));
    }
}