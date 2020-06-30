<?php


class ItemService {

    function getIndexedActiveItemDescriptionsList()
    {
        $items = Item::getActiveItems();
        $item_list = array();
        foreach($items as $item)
        {
            $item_list[$item->IDItem] = $item->Description;
        }

        return $item_list;
    }
}
