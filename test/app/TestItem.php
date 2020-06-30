<?php

require_once('app/Item.php');

class TestItem extends PHPUnit_Framework_TestCase
{
    function test_whenGetActiveItems_thenObtainListOfAllActiveItems(){
        $items = Item::getActiveItems();

        $this->assertEquals(4, count($items));
        $this->assertInstanceOf(Item::class,$items[0]);
    }
}