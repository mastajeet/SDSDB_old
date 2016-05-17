<?php

require_once('../app/inspection_piscine.php');


class test_installation extends PHPUnit_Framework_TestCase
{
    function test_constructeur(){
        $inspection_piscine = new inspection_piscine(32);
        $this->assertEquals($inspection_piscine->IDInstallation,58);
    }

    function test_constructeur_2(){
        try{
            $inspection_piscine = new inspection_piscine(-5);
            $this->assertEquals(1,-1);
        }
        catch(Exception $e) {
            $this->assertEquals(1,1);
        }
    }
}