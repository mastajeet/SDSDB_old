<?php
/**
 * Created by PhpStorm.
 * User: jtbai
 * Date: 01/06/18
 * Time: 9:18 AM
 */

class Item extends BaseModel
{
    public $Prix1;
    public $Description;
    public $IDItem;

    static function define_table_info(){
        return array("model_table" => 'item',
            "model_table_id" => 'IDItem');
    }

    static function getActiveItems(){
        $item_array = array();
        $sql_class = new SQLClass();
        list($model_table, $model_table_id) = array_values(self::define_table_info());

        $active_item_query = "SELECT ".$model_table_id." FROM ".$model_table." WHERE Actif";
        $sql_class->Select($active_item_query);
        while($item_id_cursor = $sql_class->FetchAssoc())
        {
            $item_id = $item_id_cursor[$model_table_id];
            $item_array[] = new self($item_id);
        }

        return $item_array;
    }
}
