<?php

require_once('app/responsable.php');

class TestResponsable extends PHPUnit_Framework_TestCase
{
    function test_whenConstruct_thenFullNameValueIsGenerated(){
        $responsable = new Responsable(0);
        $expected_name  = "M. prenom nom";
        $this->assertEquals($expected_name, $responsable->full_name);
    }
}