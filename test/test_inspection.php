<?php

require_once('../app/inspection.php');
require_once('../mysql_class_qc.php');

class test_installation extends PHPUnit_Framework_TestCase
{
    function test_constructeur(){
        $inspection = new inspection(32);
        $this->assertEquals($inspection->IDInstallation,58);
    }

    function test_inspection_type_piscine(){
        $inspection = new inspection(32);
        $this->assertEquals($inspection->InspectionType,"Piscine");
    }

//    function test_inspection_type_plage(){
//        $inspection = new inspection(32);
//        $this->assertEquals($inspection->InspectionType,"Piscine");
//    }


    function test_constructeur_2(){
        try{
            $inspection = new inspection(-5);
            $this->assertEquals(1,-1);
        }
        catch(Exception $e) {
            $this->assertEquals(1,1);
        }
    }
}