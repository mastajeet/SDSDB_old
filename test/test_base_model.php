<?php
require_once('../app/base_model.php');

class test_base_model extends PHPUnit_Framework_TestCase
{

    public function test_unimplmented(){
        try{
            $this->base_model = new base_model(1);
            $this->assertEquals(1,-1);
        }
        catch(NotImplementedException $e){
            $this->assertEquals(1,1);
        }
    }
}