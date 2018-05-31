<?php
require_once('app/BaseModel.php');
require_once('mysql_class_test.php');

class test_base_model extends PHPUnit_Framework_TestCase
{

    public function test_validate_set_onload(){
        $this->base_model = new BaseModel(array('key1'=>'value1'));
        $this->assertTrue(in_array('key1',$this->base_model->updated_values));
    }

    public function test_validate_set_onmodify(){
        $this->base_model = new BaseModel(array('key1'=>'value1'));
        $this->base_model->Test = "testvaleur";
        $this->assertTrue(in_array('Test',$this->base_model->updated_values));
    }


    public function test_unimplmented(){
        try{
            $this->base_model = new BaseModel(1);
            $this->assertEquals(1,-1);
        }
        catch(NotImplementedException $e){
            $this->assertEquals(1,1);
        }
    }

    public function test_value_convertion_string(){
        $data_type = BaseModel::convert_data("test1",'string');
        $this->assertEquals($data_type,"\"test1\"");
    }

    public function test_value_convertion_int(){
        $data_type = BaseModel::convert_data("1",'int');
        $this->assertEquals($data_type,1);
        $this->assertEquals(is_int($data_type),true);
    }

    public function test_value_convertion_float(){
        $data_type = BaseModel::convert_data("1",'float');
        $this->assertEquals($data_type,1);
        $this->assertEquals(is_float($data_type),true);
    }

    public function test_value_convertion_unknown(){
        try{
            $data_type = BaseModel::convert_data("1",'unknown');
            $this->assertEquals(-1,1);
        }
        catch(UnexpectedValueException $e){

        }
    }

    public function test_data_type_guessing_string(){
        $this->assertEquals('string',BaseModel::guess_data_type('test1'));
    }

    public function test_data_type_guessing_int(){
        $this->assertEquals('int',BaseModel::guess_data_type(1234));
    }

    public function test_data_type_guessing_float(){
        $this->assertEquals('float',BaseModel::guess_data_type(1234.));
    }

    public function test_get_data_type_string(){
        $this->assertEquals('string',BaseModel::get_data_type('Test1','Value1'));
    }

    public function test_get_data_type_int(){
        $this->assertEquals('int',BaseModel::get_data_type('Test1',1));
    }
}