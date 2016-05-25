<?php
require_once('../app/base_model.php');

class test_base_model extends PHPUnit_Framework_TestCase
{

    public function test_validate_set_onload(){
        $this->base_model = new base_model(array('key1'=>'value1'));
        $this->assertTrue(in_array('key1',$this->base_model->UpdatedValues));
    }

    public function test_validate_set_onmodify(){
        $this->base_model = new base_model(array('key1'=>'value1'));
        $this->base_model->Test = "testvaleur";
        $this->assertTrue(in_array('Test',$this->base_model->UpdatedValues));
    }


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