<?php

require_once('app/installation.php');
require_once('mysql_class_test.php');

class test_installation extends PHPUnit_Framework_TestCase
{
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
}