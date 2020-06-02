<?php

class ModelToKVPConverter{
    static function to_kvp($model_list, $id_key, $value_key){
        $kvp = array();
        foreach($model_list as $model){
            $kvp[$model->$id_key] = $model->$value_key;
        }

        return($kvp);
    }
}