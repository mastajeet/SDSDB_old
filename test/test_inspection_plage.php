<?php

require_once('../app/inspection_plage.php');


class test_installation extends PHPUnit_Framework_TestCase
{
    function test_constructeur(){
        $inspection_plage = new inspection_plage(32);
        $this->assertEquals($inspection_plage->IDInstallation,58);
    }

    function test_constructeur_2(){
        try{
            $inspection_plage = new inspection_plage(-5);
            $this->assertEquals(1,-1);
        }
        catch(Exception $e) {
            $this->assertEquals(1,1);
        }
    }
}