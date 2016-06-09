<?php

class NotImplementedException extends BadMethodCallException
{
}

class base_model
{
    public $updated_values = array();

    function select_all_query()
    {
        $this->define_table_info();
        return ("SELECT * FROM " . $this->model_table . " WHERE " . $this->model_table_id . " = ");
    }

    function define_data_types()
    {
        throw new NotImplementedException();
    }

    function define_table_info()
    {
        throw new NotImplementedException();
    }


    function __construct($Arg)
    {
        if (is_null($Arg)) {
            return FALSE;
        }

        if (is_array($Arg)) {
            foreach ($Arg as $Key => $val) {
                $this->$Key = $val;
                $this->updated_values[] = $Key;
            }
        }

        if (is_numeric($Arg)) {
            //Assuming ID, search for ID
            $SQL = new sqlclass();
            $SQL->SELECT($this->select_all_query() . $Arg);

            $Req = $SQL->FetchAssoc();
            foreach ($Req as $Key => $val) {
                $this->$Key = $val;
                $this->updated_values[] = $Key;
            }
            $SQL->CloseConnection();
        }
    }

    function __set($item, $value)
    {

        if (!in_array($item, array('data_type', 'updated_values', 'model_table', 'model_table_id')))
            if (!in_array($item, $this->updated_values)) {
                $this->updated_values[] = $item;
            }
        $this->$item = $value;
    }


    function generate_update_statement()
    {
        $model_table_id = $this->model_table_id;
        $Req = "";
        $Req .= "UPDATE " . $this->model_table . " SET ";
        foreach ($this->updated_values as $value) {
            $value_type = $this->get_data_type($value, $this->$value);
            if ($value_type != "ID") {
                $field = $value;
                $field_value = $this->convert_data($this->$value, $value_type);
                $Req .= $field . "=" . $field_value . ", ";
            }
        }
        $Req = substr($Req, 0, -2);
        $Req .= " WHERE " . $this->model_table_id . " = " . $this->$model_table_id;
        return ($Req);
    }

    function generate_insert_statement()
    {
        $Req = "";
        $Req .= "INSERT INTO " . $this->model_table . "(";
        $fields = "";
        $values = "";
        foreach ($this->updated_values as $value) {
            $value_type = $this->get_data_type($value, $this->$value);
            if ($value_type != "ID") {
                $fields .= "`" . $value . "`, ";
                $field_value = $this->convert_data($this->$value, $value_type);
                $values .= $field_value . ", ";

            }
        }
        $values = substr($values, 0, -2);
        $fields = substr($fields, 0, -2);
        $Req .= $fields . ") VALUES (" . $values . ")";
        return ($Req);
    }

    function save()
    {
        $this->define_data_types();
        $this->define_table_info();
        $model_table_id = $this->model_table_id;

        if ($this->$model_table_id == 0) {
            if (count($this->updated_values) > 0) {
                $this->insert($this->generate_insert_statement());
                return true;
            }
        } else {
            if (count($this->updated_values) > 0) {
                $this->insert($this->generate_update_statement());
                return true;
            }
        }
//        est-ce qu'on remonte une exception quand le update / insert n'a pas fonctionne? comment on le detecte?
        return false;
    }

    function insert($Req)
    {
        $SQL = new sqlclass();
        $SQL->Insert($Req);
        $SQL->CloseConnection();
    }

    function update($Req)
    {
        $SQL = new sqlclass();
        $SQL->Update($Req);
        $SQL->CloseConnection();
    }

    function convert_data($data, $data_type)
    {
        if ($data_type == "string") {
            return "'" . addslashes($data) . "'";
        }
        if ($data_type == "int") {
            return intval($data);
        }
        if ($data_type == "float") {
            return floatval($data);
        }
        throw new UnexpectedValueException;
    }

    function guess_data_type($value)
    {

        if (is_int($value))
            return 'int';
        if (is_float($value))
            return 'float';
        if (is_numeric($value)) {
            if (strrpos('.', $value))
                return 'float';
            return 'int';
        }
        if (is_string($value))
            return 'string';
        if (is_numeric($value))
            return 'int';
        else
            return 'string';

    }

    function get_data_type($field, $value)
    {
        if (isset($this->data_type) and array_key_exists($field, $this->data_type)) {
            return $this->data_type[$field];
        } else {
            return base_model::guess_data_type($value);
        }
    }

}

