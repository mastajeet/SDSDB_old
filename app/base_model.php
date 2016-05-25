<?php

class NotImplementedException extends BadMethodCallException
{}

class base_model{
    public $UpdatedValues = array();

    function select_all_query(){
        throw new NotImplementedException();
    }

    function define_data_types(){
        throw new NotImplementedException();
    }



    function __construct($Arg)
    {
        if (is_null($Arg)) {
            return FALSE;
        }

        if(is_array($Arg)){
            foreach ($Arg as $Key => $val) {
                $this->$Key = $val;
                $this->UpdatedValues[] = $Key;
            }
        }

        if (is_numeric($Arg)) {
            //Assuming ID, search for ID
            $SQL = new sqlclass();
            $SQL->SELECT($this->select_all_query() . $Arg);
            $Req = $SQL->FetchArray();
            foreach ($Req as $Key => $val) {
                $this->$Key = $val;
                $this->UpdatedValues[] = $Key;
            }
            $SQL->CloseConnection();
        }
    }

    function __set($item,$value){
        $this->$item = $value;
        if(!in_array($item,$this->UpdatedValues)){
            $this->UpdatedValues[] = $item;
        }
        $this->$item = $value;
    }

    function save(){
        $this->define_data_types();

    }

    function convert_data($data,$data_type){
        if($data_type=="string"){
            return "'".addslashes($data)."'";
        }
        if($data_type=="int"){
            return intval($data);
        }
        if($data_type=="float"){
            return floatval($data);
        }
        throw new UnexpectedValueException;
    }
}

