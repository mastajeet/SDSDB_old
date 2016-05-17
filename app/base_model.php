<?php
include_once('../mysql_class_qc.php');
class NotImplementedException extends BadMethodCallException
{}



class base_model{

    function select_all_query(){
        throw new NotImplementedException();
    }


    function __construct($Arg)
    {
        if (is_null($Arg)) {
            return FALSE;
        }

        if (is_numeric($Arg)) {
            //Assuming ID, search for ID
            $SQL = new sqlclass();
            $SQL->SELECT($this->select_all_query() . $Arg);
            $Req = $SQL->FetchArray();
            foreach ($Req as $Key => $val) {
                $this->$Key = $val;
            }
            $SQL->CloseConnection();
        }
    }

}