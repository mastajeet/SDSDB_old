<?php

include_once('helper/ItemService.php');

class TestItemService extends PHPUnit_Framework_TestCase{

    private $item_service;
    /**
     * @before
     */
    function setUp(){
        $this->item_service = new ItemService();
    }

    function test_givingTimeSerivce_whenGetIndexedActiveItemDescriptionsList_thenObtainIndexedArrayOfActiveItemDescriptions(){
        $item_list = $this->item_service->getIndexedActiveItemDescriptionsList();

        $an_index = array_keys($item_list)[0];
        $a_value = array_values($item_list)[0];

        $this->assertTrue(is_numeric($an_index));
        $this->assertTrue(is_string($a_value));
        $this->assertEquals(count($item_list),4);
    }
}
