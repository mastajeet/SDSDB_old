<?php
require_once('helper/ModelToKVPConverter.php');

class TestModelToKVPConverter extends PHPUnit_Framework_TestCase{

    const A_VALUE = "value_1";
    const ANOTHER_VALUE = "value_2";

    const AN_ID = 1;
    const ANOTHER_ID = 2;

    function get_dummy_models(){
        $dummy_model_1 = new DummyModel();
        $dummy_model_1->id = self::AN_ID;
        $dummy_model_1->value = self::A_VALUE;

        $dummy_model_2 = new DummyModel();
        $dummy_model_2->id = self::ANOTHER_ID;
        $dummy_model_2->value = self::ANOTHER_VALUE;

        $dummy_models = array($dummy_model_1, $dummy_model_2);
        return($dummy_models);
    }

    function test_givenCorrectModelWithCorrectFields_whenConvert_thenGenerateKVP(){
        $dummy_models = self::get_dummy_models();

        $dummy_models_as_kvp = ModelToKVPConverter::to_kvp($dummy_models, "id", "value");

        $expected_kvp = array(self::AN_ID=>self::A_VALUE, self::ANOTHER_ID=>self::ANOTHER_VALUE);
        $this->AssertEquals($expected_kvp, $dummy_models_as_kvp);
    }

}

class DummyModel{
    public $id;
    public $value;
}